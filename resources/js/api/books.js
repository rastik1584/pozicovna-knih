import axios from 'axios'

export default  {

    getBooks(filter) {
        return axios.get('/api/books', {
            params: filter
        })
    },

    getBookAuthorsForm() {
        return axios.get('/api/book-authors-form')
    },

    storeBooks(books) {
        return axios.post('/api/books', {
            ...books
        })
    },

    getBook(book) {
        return axios.get('/api/books/'+book+'/edit')
    },

    updateBook(books) {
        return axios.put('/api/books/'+books.id, {
            ...books
        })
    },

    updateBorrowed(book) {
        return axios.post('/api/books/update-is-borrowed/'+book.id, {
            is_borrowed: book.is_borrowed,
        })
    },

    deleteBook(book) {
        return axios.delete('/api/books/'+book.id)
    }

}
