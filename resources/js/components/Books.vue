<template>
    <div>
        <h1>Knihy</h1>
        <div class="create-button">
            <label for="filter">Filter:</label>
            <input v-model="form.filters" id="filter" class="form-control-sm" ref="filter_text" autofocus="autofocus">
            <label for="borr">Vypožičané:</label>
            <input type="checkbox" id="borr" v-model="form.borrowed_filter">
            <button @click="resetFilter" class="btn btn-sm btn-info">Reset</button>
            <router-link :to="{path: '/knihy/form'}" class="btn btn-sm btn-primary">Pridať knihu</router-link>
        </div>
        <p v-if="showMessage" class="flash-message success mb-2">{{ flashMessage }}</p>


        <table class="table table-responsive-sm inverse mt-3">
            <thead>
            <tr>
                <th>Názov knihy</th>
                <th>Autor</th>
                <th>Vypožičaná</th>
                <th>Akcie</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="book in booksList">
                <td>{{ book.title }}</td>
                <td>{{ book.author_full_name }}</td>
                <td>
                    <toggle-button v-model="book.is_borrowed" @change="updateIsBorrowed(book)" :labels="{checked: 'Áno', unchecked: 'Nie'}" :sync="true" />
                </td>
                <td class="actions">
                    <router-link :to="{path: '/knihy/form/'+book.id}">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>
                    </router-link>
                    <form @submit.prevent="reallyDelete(book)">
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
import {mapActions, mapGetters, mapMutations } from 'vuex'
import { ToggleButton } from 'vue-js-toggle-button'
import { pickBy, mapValues, throttle } from "lodash";
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

export default {
    name: "Books",
    data() {
        return {
            form: {
                filter: "",
                borrowed_filter: false,
            },
            showMessage: false,
            flashMessage: null
        }
    },
    created() {
        this.fetchBooks()
        const message = localStorage.getItem('flash_message')
        if(message !== null) {
            this.showFlashMessage(message)
            localStorage.removeItem('flash_message')
        }
    },
    methods: {
        ...mapActions(['fetchBooks', 'updateIsBorrowedBook', "deleteBooks"]),
        ...mapMutations(['setFlashMessage']),
        resetFilter() {
            this.form = mapValues( this.form,() => null)
        },
        async updateIsBorrowed(book) {
            await this.updateIsBorrowedBook(book).then(message => {
                this.showFlashMessage(message)
            })
        },
        reallyDelete(book) {
            if(window.confirm('Naozaj chcete knihu vymazať ?')) {
                this.deleteBooks(book).then(message => {
                    this.fetchBooks()
                    this.showFlashMessage(message)
                })
            } else {
                return false
            }
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
        ...mapGetters(['getListBooks']),
        booksList() {
            return this.getListBooks
        },
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form)
                if(Object.keys(query).length === 0) {
                    query = Object({borrowed_filter: 0})
                }
                this.fetchBooks(query)
            }, 150),
            deep: true,
        }
    },
    components: {
        ToggleButton,
    }
}
</script>

<style lang="scss" scoped>

</style>
