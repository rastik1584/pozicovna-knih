<template>
    <div>
        <div class="container">
            <h1>{{ knihy.id ? 'Upraviť knihu' : 'Pridať knihu' }}</h1>

            <form @submit.prevent="saveForm(knihy)">
                <div class="form-group">
                    <label for="title">Názov knihy</label>
                    <input id="title" v-model="knihy.title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="author">Autor</label>
                    <Select2 v-model="knihy.author_id" :options="authors" required />
                </div>
                <div class="form-group">
                    <label for="borrowed">Vypožičaná</label>
                    <input type="checkbox" id="borrowed" v-model="knihy.is_borrowed" >
                </div>
                <button class="btn btn-primary" type="submit">Uložit</button>
            </form>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Select2 from 'v-select2-component'
import {clone} from "lodash";

export default {
    name: "BookForm",
    data() {
        return {
        }
    },
    async created() {
        if(this.$route.params.id) {
            this.fetchBook(this.$route.params.id)
        }
        await this.fetchBookAuthors()
    },
    methods: {
        ...mapActions(['fetchBookAuthors', "fetchBook", "saveBook"]),
        async saveForm(book) {
            await this.saveBook(book).then(data => {
                this.$router.push('/knihy')
            })
            return true
        },
    },
    computed: {
        ...mapGetters(['getBook', 'getAuthorsForm']),

        knihy() {
            return this.getBook
        },
        authors() {
            return this.getAuthorsForm
        },
    },
    components: {
        Select2
    }
}
</script>

<style lang="scss" scoped>

</style>
