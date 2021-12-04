<template>
    <Head title="Autori Fomrulár" />
    <h1>Autori formulár</h1>
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
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import {Head, Link} from '@inertiajs/inertia-vue3'
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "AuthorForm",
    props: ['author'],
    layout: AppLayout,
    components: {
        Head,
        Link,
    },
    methods: {
        saveForm(author) {
            if(this.author.name !== "" && this.author.surname !== "") {
                if(this.author.id) { // update
                    Inertia.put(route('autori.update', author.id), this.author)
                } else { // create
                    Inertia.post(route('autori.store'), this.author)
                }
            }

        }
    }
}
</script>

<style scoped>
   form button {
       margin-top: 10px;
   }
</style>
