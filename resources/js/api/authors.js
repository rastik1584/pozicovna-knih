import axios from "axios";
export default {
    getAuthors(filters) {
        return axios.get('/api/authors', {
            params: filters
        })
    },
    getAuthor(author) {
        return axios.get('/api/authors/'+author+'/edit')
    },
    storeAuthor(author) {
        return axios.post('/api/authors', {
            ...author
        })
    },
    updateAuthor(author) {
        return axios.put('/api/authors/'+author.id, {
            ...author
        })
    },
    deleteAuthor(author) {
        return axios.delete('/api/authors/'+author.id)
    }
}
