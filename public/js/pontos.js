import {getFormEntries, handleRequest} from "./utils.mjs";

document.addEventListener('alpine:init', () => {

    Alpine.data('pontos', function () {
        return {
            pontoId: null,
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
                const data = getFormEntries(this.$refs.storePonto)
                handleRequest('PATCH', this.$refs.storePonto.action, data, this.$refs.storePonto).then(response => {
                    if (response) {
                        this.closeModal()
                    }
                })
            },
            deletePonto(id) {
                if (confirm("Tem certeza de que deseja excluir esse registro?")) {
                    this.$wire.call('deletePonto', id)
                }
            }
        }
    })
})