import books from '../../api/books'

export default  {
    state: {
        listBooks: null,
        book: {
            title: '',
            author_id: 0,
            is_borrowed: false
        },
        emptyBook: {
            title: '',
            author_id: 0,
            is_borrowed: false
        },
        flashMessage: null,
        authorsForm: []
    },
    getters: {
        getListBooks: state => {
            return state.listBooks
        },
        getBook: state => {
            return state.book
        },
        getFlashMessage: state => {
            return state.flashMessage
        },
        getAuthorsForm: state => {
            return state.authorsForm
        },
    },
    actions: {
        async fetchBooks({commit, getters}, filter) {
             return await new Promise((resolve, reject) => {
                books.getBooks(filter).then(response => {
                    commit('setListBooks', response.data.books.data)
                })
            }).catch(err => {
                console.log('get books', err)
            })
        },
        async fetchBook({commit, getters}, book) {
            return await new Promise((resolve, reject) => {
                books.getBook(book).then(response => {
                    commit('setBook', response.data.data)
                })
            }).catch(err => {
                console.log('error', err)
            })
        },
        async fetchBookAuthors({commit}) {
            return await new Promise((resolve, reject) => {
                books.getBookAuthorsForm().then(response => {
                    commit('setAuthorsForm', response.data.data)
                })
            }).catch(err => {
                console.log(err)
            })
        },

        saveBook({commit, getters, state}, book) {
            console.log(book)
            if(book.id) {
                return new Promise((resolve, reject) => {
                    books.updateBook(book).then(response => {
                        resolve(response.data.message)
                        localStorage.setItem('flash_message', response.data.message)
                        commit('setEmptyBook', state.emptyBook)
                    })
                }).catch(err => {
                    console.log('save', err)
                })
            } else {
                return new Promise((resolve, reject) => {
                    books.storeBooks(book).then(response => {
                        resolve(response.data.message)
                        localStorage.setItem('flash_message', response.data.message)
                        commit('setEmptyBook', state.emptyBook)
                    })
                }).catch(err => {
                    console.log('save', err)
                })
            }
        },
        updateIsBorrowedBook({commit, getters}, book) {
            return new Promise((resolve, reject) => {
                books.updateBorrowed(book).then(response => {
                    resolve(response.data.message)
                })
            }).catch(err => {
                console.log(err)
            })
        },
        deleteBooks({commit, getters}, book) {
            console.log(book)
            return new Promise((resolve, reject) => {
                books.deleteBook(book).then(response => {
                    resolve(response.data.message)
                })
            }).catch(err => {
                console.log(err)
            })
        }
    },
    mutations: {
        setListBooks(state, list) {
            state.listBooks = list
        },
        setBook(state, book) {
            state.book = book
        },
        setFlashMessage(state, message) {
            state.flashMessage = message
        },
        setAuthorsForm(state, authors) {
            state.authorsForm = authors
        },
        setEmptyBook(state, book) {
            state.book = book
        }

    }
}
