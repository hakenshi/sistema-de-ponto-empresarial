import {getFormEntries, handleRequest, renderErrorMessage} from "./utils.mjs"

document.addEventListener('alpine:init', () => {
    Alpine.data('userModalData', function () {
        return {
            previewImage: null,
            userId: null,
            matricula: null,
            curso: null,
            openUserModal() {
                this.$refs.addUserRef.showModal()
            },
            editUserModal(id) {
                this.userId = id;
                this.$wire.call('loadUser', id).then(() => {
                    this.$refs.editUserRef.showModal()
                })
            },
            updateStatus(id, status) {
                if (confirm(`Tem certeza de que deseja ${status == 1 ? 'inativar' : 'ativar'} esse usuário?`)) {
                    this.$wire.call('updateStatus', id)
                }
            },
            closeEditModal() {
                this.userId = null;
                this.$wire.call('loadUser', null)
                this.$refs.editUserRef.close();
            },
            closeUserModal() {
                this.$refs.addUserRef.close()
            },
            openFileInput() {
                this.$refs.fotoPerfilRef.click()
            },
            setPreviewImage(e) {
                const file = e.target.files[0]
                if (file) {
                    const reader = new FileReader()
                    reader.onload = e => {
                        this.previewImage = e.target.result
                    }
                    reader.readAsDataURL(file)
                }
            },
            handleUpdateSubmit() {
                const data = getFormEntries(this.$refs.editForm)

                handleRequest('PATCH', this.$refs.editForm.action, data, this.$refs.editForm).then(response => {
                    if (response) {
                        this.closeEditModal()
                    }
                })
            }, handleStoreSubmit() {
                const data = getFormEntries(this.$refs.storeForm)
                handleRequest('POST', this.$refs.storeForm.action, data, this.$refs.storeForm).then(response => {
                    if (response) {
                        this.closeEditModal()
                    }
                })
            },
            deleteUser(id) {
                if (confirm(`Tem certeza que deseja excluir este usuário?`)) {
                    this.$wire.call('destroy', id).then(() => {
                        alert('Usuário apagado com sucesso.')
                    }).catch(() => {
                        alert('Ocorreu um erro ao excluir o usuário.')
                    })
                }
            }
        }
    })
})

