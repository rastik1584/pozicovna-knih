import authors from '../../api/authors'

export default {
    state: {
        listAuthors: {},
        author: {
            name: '',
            surname: ''
        },
        emptyAuthor: {
            name: '',
            surname: ''
        },
        flashMessage: ''
    },
    getters: {
        getListAuthors: state => {
            return state.listAuthors
        },
        getOnlyAuthor: state => {
            return state.author
        },
    },
    actions: {
        async fetchAuthors({commit, getters}, filters) {
            return await new Promise((resolve, reject) => {
                authors.getAuthors(filters).then(response => {
                    resolve(response.data.authors.data)
                    commit('setListAuthors', response.data.authors.data)
                })
            }).catch(err => {
                console.log(err)
            })
        },
        async fetchAuthor({commit, getter}, author) {
            return await new Promise((resolve, reject) => {
                authors.getAuthor(author).then(response => {
                    resolve(response.data.data)
                    commit('setAuthor', response.data.data)
                })
            }).catch(err => {
                console.log(err)
            })
        },
        saveAuthor({commit, getters}, author) {
            return new Promise((resolve, reject) => {
                if(author.id) {
                    authors.updateAuthor(author).then(response => {
                        resolve(response.data.message)
                        localStorage.setItem('flash_message', response.data.message)
                        commit('setEmptyAuthor')
                    })
                } else {
                    authors.storeAuthor(author).then(response => {
                        resolve(response.data.message)
                        localStorage.setItem('flash_message', response.data.message)
                        commit('setEmptyAuthor')
                    })
                }
            }).catch(err => {
                console.log(err)
            })
        },
        deleteAuthor({commit, getters}, author) {
            return new Promise((resolve, reject) => {
                authors.deleteAuthor(author).then(response => {
                    resolve(response.data.message)
                    commit('setFlashMessage', response.data.message)
                })
            })
        }
    },
    mutations: {
        setListAuthors(state, authors) {
            state.listAuthors = authors
        },
        setAuthor(state, author) {
            state.author = author
        },
        setEmptyAuthor(state) {
            state.author = state.emptyAuthor
        },
        setFlashMessage(state, message) {
            state.flashMessage = message
        }
    }
}
