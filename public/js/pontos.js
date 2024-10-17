import {getFormEntries, handleRequest} from "./utils.mjs";

document.addEventListener('alpine:init', () => {

    Alpine.data('pontos', function () {
        return {
            pontoId: null,
            openExcelModal() {
                this.$refs.excelRef.showModal()
            },
            closeExcelModal() {
                this.$refs.excelRef.close()
            },
            openStoreModal() {
                this.$refs.pontoRef.showModal()
            },
            closeStoreModal() {
                this.$refs.pontoRef.close()
            },
            openModal(id) {
                this.pontoId = id

                this.$wire.call('loadPonto', id).then(() => {
                    this.$refs.editPontoRef.showModal()
                })
            },
            closeModal() {
                this.$wire.call('loadPonto', null)
                this.$refs.editPontoRef.close()
            },
            handleStore() {
                const data = getFormEntries(this.$refs.storePonto)
                handleRequest('POST', this.$refs.storePonto.action, data, this.$refs.storePonto).then(response => {
                    if (response.redirected) {
                        this.closeStoreModal()
                        window.location.reload()
                    }
                })
            },
            handleUpdate() {
                const data = getFormEntries(this.$refs.updatePonto)
                handleRequest('PATCH', this.$refs.updatePonto.action, data, this.$refs.storePonto).then(response => {
                    if (response) {
                        this.closeModal()
                        window.location.reload()
                    }
                    console.log(response)
                })
            },
            deletePonto(id) {
                if (confirm("Tem certeza de que deseja excluir esse registro?")) {
                    this.$wire.call('deletePonto', id)
                }
            },
            exportExcel() {

                const data = getFormEntries(this.$refs.exportRef)

                handleRequest('POST', this.$refs.exportRef.action, data, this.$refs.exportRef).then(async (response) => {
                    const file = await response.blob()
                    const url = URL.createObjectURL(new Blob([file]))
                    const a = document.createElement('a')
                    a.href = url
                    a.download = 'pontos.xlsx'
                    a.click()
                    a.remove()
                    URL.revokeObjectURL(url)
                })
            }
        }
    })
})