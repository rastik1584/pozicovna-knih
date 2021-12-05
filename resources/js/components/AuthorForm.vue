<template>
    <div>
        <h1>{{ author.id ? 'Pridať autora' : 'Editovanie autora'}}</h1>
        <div class="container">
            <form @submit.prevent="saveForm(author)">
                <div class="form-group">
                    <label for="firstname">Meno</label>
                    <input id="firstname" v-model="author.name" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="lastName">Priezvisko</label>
                    <input id="lastName" v-model="author.surname" class="form-control" />
                </div>

                <button class="btn btn-primary" type="submit">Uložiť</button>

            </form>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters, mapMutations } from 'vuex'


export default {
    name: "AuthorForm",
    data() {
        return {}
    },
    async created() {
        if(this.$route.params.id) {
            this.fetchAuthor(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions(["fetchAuthor", "saveAuthor"]),
        saveForm(author) {
            this.saveAuthor(author).then(message => {
                this.$router.push('/autori')
                return true
            })
        }
    },
    computed: {
        ...mapGetters(["getOnlyAuthor"]),
        author() {
            return this.getOnlyAuthor
        }
    },
    components: {

    }
}
</script>

<style scoped>

</style>
