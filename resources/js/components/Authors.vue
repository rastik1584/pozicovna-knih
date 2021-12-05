<template>
    <div>
        <h1>Autori</h1>

        <div class="create-button">
            <label for="filter">Filter:</label>
            <input v-model="form.filters" id="filter" class="form-control-sm" ref="filter_text" autofocus="autofocus">
            <button @click="resetFilter" class="btn btn-sm btn-info">Reset</button>
            <router-link :to="{path: '/autori/form'}" class="btn btn-primary">Pridať autora</router-link>
        </div>
        <p v-if="showMessage" class="flash-message success mb-2">{{ flashMessage }}</p>
        <table class="table table-responsive-sm inverse mt-3">
            <thead>
            <tr>
                <th>Meno</th>
                <th>Priezvisko</th>
                <th>Počet kníh</th>
                <th>Akcie</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="author in listAuthors">
                <td>{{ author.name }}</td>
                <td>{{ author.surname }}</td>
                <td>{{ author.book_count }}</td>
                <td class="actions">
                    <router-link :to="{path: '/autori/form/'+author.id}">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>
                    </router-link>
                    <form @submit.prevent="reallyDelete(author)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from 'vuex'
import { library } from "@fortawesome/fontawesome-svg-core";
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas);
import { fab } from '@fortawesome/free-brands-svg-icons';
library.add(fab);
import { far } from '@fortawesome/free-regular-svg-icons';
library.add(far);
import { dom } from "@fortawesome/fontawesome-svg-core";
dom.watch();
import {mapValues, throttle, pickBy} from "lodash";

export default {
    name: "Authors",
    data() {
        return {
            form: {
                filter: '',
            },
            showMessage: false,
            flashMessage: ''
        }
    },
    created() {
        const message = localStorage.getItem('flash_message')
        if(message !== null) {
            localStorage.removeItem('flash_message')
            this.showFlashMessage(message)
        }
        this.fetchAuthors()
    },
    methods: {
        ...mapActions(['fetchAuthors', "deleteAuthor",]),
        ...mapMutations(["setFlashMessage"]),
        reallyDelete(author) {
            if(window.confirm('Naozaj chcete autora vymazať ? Vymazaním autora vymažete aj jeho knihu!')) {
                this.deleteAuthor(author).then(message => {
                    this.showFlashMessage(message)
                })
            } else {
                return false
            }
        },
        resetFilter() {
            this.form = mapValues(this.form, () => null)
        },
        showFlashMessage(message) {
            this.flashMessage = message
            this.showMessage = true
            setTimeout(() => {
                this.showMessage = false
                this.setFlashMessage("")
            }, 3000)
        }
    },
    computed: {
        ...mapGetters(['getListAuthors']),
        listAuthors() {
            return this.getListAuthors
        }
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form)
                this.fetchAuthors(query)
            },150),
            deep: true,
        }
    },
    components: {

    }
}
</script>

<style scoped>

</style>
