<template>
    <Head title="Knihy" />

    <h1>Knihy</h1>

    <div class="create-button">
        <label for="filter">Filter:</label>
        <input v-model="form.filters" id="filter" class="form-control-sm" ref="filter_text" autofocus="autofocus">
        <label for="borr">Vypožičané:</label>
        <input type="checkbox" id="borr" v-model="form.borrowed_filter">
        <button @click="resetFilter" class="btn btn-sm btn-info">Reset</button>
        <Link :href="route('knihy.create')" class="btn btn-primary"> Pridať knihu </Link>
    </div>

    <p v-if="$page.props.flash.success && this.showMessage"  class="flash-message success" id="flash-msg">{{ $page.props.flash.success }}</p>
    <p v-if="$page.props.flash.error && this.showMessage" class="flash-message error">{{ $page.props.flash.error }}</p>

    <table class="table table-responsive inverse">
        <thead>
        <tr>
            <th>Názov knihy</th>
            <th>Autor</th>
            <th>Vypožičaná</th>
            <th>Akcie</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="book in knihy.data">
            <td>{{ book.title }}</td>
            <td>{{ book.author_full_name }}</td>
            <td>
                <Toggle v-model="book.is_borrowed" @click="updateIsBorrowed(book)" on-label="Áno" off-label="Nie" />
            </td>
            <td class="actions">
                <Link :href="route('knihy.edit', book.id)">
                    <button class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button> </Link>
                <form @submit.prevent="reallyDelete(book)">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/AppLayout";
import {Inertia} from "@inertiajs/inertia";
import Toggle from '@vueform/toggle'
import {throttle, pickBy, mapValues, omitBy, isNaN, isBoolean} from "lodash";


export default {
    name: "Books",
    props: ['knihy', 'filters'],
    data() {
        return {
            checked: false,
            showMessage: true,
            form: {
                filters: this.filters.filters,
                borrowed_filter: this.filters.borrowed_filter === null ? false : !!parseInt(this.filters.borrowed_filter)
            },
        }
    },
    mounted() {
        this.$refs.filter_text.focus()
    },
    methods: {
        reallyDelete(book) {
            if(window.confirm('Naozaj chcete knihu vymazať ?')) {
                Inertia.delete(route('knihy.destroy', book.id), {
                    onSuccess: page => {
                        setTimeout(() => {
                            this.$page.props.flash.success = null
                        }, 2000)
                    }
                })
            } else {
                return false
            }
        },
        updateIsBorrowed(knihy) {
            Inertia.post(route('books.update_borrowed', knihy.id), knihy)
        },
        resetFilter() {
            this.form = mapValues(this.form, () => null)
        },
    },
    computed: {

    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form)
                if(Object.keys(query).length === 0) {
                    query = Object({borrowed_filter: 0})
                }
                Inertia.get(route('knihy.index', query))
            }, 150),
            deep: true,
        }
    },
    components: {
        Head,
        Link,
        Toggle,
    },
    layout: AppLayout,
}
</script>
<style src="@vueform/toggle/themes/default.css"></style>
<style lang="scss" scoped>

</style>
