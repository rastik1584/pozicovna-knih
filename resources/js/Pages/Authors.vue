<template>
    <Head title="Autori" />
    <h1>Autori</h1>

    <div class="create-button">
        <label for="filter">Filter:</label>
        <input v-model="form.filters" id="filter" class="form-control-sm" ref="filter_text" autofocus="autofocus">
        <button @click="resetFilter" class="btn btn-sm btn-info">Reset</button>
        <Link :href="route('autori.create')" class="btn btn-primary"> Pridať autora </Link>
    </div>

    <p v-if="$page.props.flash.success && this.showMessage"  class="flash-message success">{{ $page.props.flash.success }}</p>
    <p v-if="$page.props.flash.error && this.showMessage" class="flash-message error">{{ $page.props.flash.error }}</p>
    <table class="table table-responsive inverse">
        <thead>
            <tr>
                <th>Meno</th>
                <th>Priezvisko</th>
                <th>Počet kníh</th>
                <th>Akcie</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="author in authors.data">
                <td>{{ author.name }}</td>
                <td>{{ author.surname }}</td>
                <td>{{ author.book_count }}</td>
                <td class="actions">
                    <Link :href="route('autori.edit', author.id)">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button> </Link>
                    <form @submit.prevent="reallyDelete(author)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/AppLayout";
import {Inertia} from "@inertiajs/inertia";
import {throttle, pickBy, mapValues} from "lodash";

export default {
    name: "Authors",
    props: ['authors', 'flash','filters'],
    layout: AppLayout,
    created() {
        if(this.$page.props.flash.success || this.$page.props.flash.error) {
            setTimeout(() => {
                this.$page.props.flash.success = null
                this.$page.props.flash.error = null
            }, 3000)
        }
    },
    mounted() {
        this.$refs.filter_text.focus()
    },
    data() {
        return {
            showMessage: true,
            form: {
                filters: this.filters.filters
            }
        }
    },
    methods: {
        reallyDelete(author) {

            if(window.confirm('Naozaj chcete autora vymazať ? Vymazaním autora vymažete aj jeho knihu!')) {
                Inertia.delete(route('autori.destroy', author.id), {
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
        resetFilter() {
            this.form = mapValues(this.form, () => null)
        }
    },
    watch: {
        form: {
            handler: throttle(function(){
                let query = pickBy(this.form)
                Inertia.get(route('autori.index', query))
            }, 150),
            deep:true,
        }
    },
    components: {
        AppLayout,
        Head,
        Link,
    },
}

</script>

<style lang="scss" scoped>

</style>
