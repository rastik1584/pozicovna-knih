<template>
    <Head :title="knihy.id ? 'Upraviť knihu' : 'Pridať knihu'" />
    <h1>{{ knihy.id ? 'Upraviť knihu' : 'Pridať knihu' }}</h1>

    <form @submit.prevent="saveForm(knihy)">
        <div class="form-group">
            <label for="title">Názov knihy</label>
            <input id="title" v-model="knihy.title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="author">Autor</label>
            <Select2 v-model="knihy.author_id" :options="authors.data" required />
        </div>
        <div class="form-group">
            <label for="borrowed">Vypožičaná {{isBorrowed}}</label>
            <input type="checkbox" id="borrowed" v-model="checked" @click="knihy.is_borrowed ? 1: 0">
        </div>
        <button class="btn btn-primary" type="submit">Uložit</button>
    </form>


</template>


<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/AppLayout";
import Select2 from 'vue3-select2-component'
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "BookForm",
    props: ['knihy', 'authors'],
    data() {
        return {
            checked: !!this.knihy.is_borrowed
        }
    },
    methods: {
        saveForm(knihy) {
            knihy.is_borrowed = this.checked
            if(knihy.id) {
                Inertia.put(route('knihy.update', knihy.id), knihy)
            } else {
                Inertia.post(route('knihy.store'), knihy)
            }
        },
    },
    layout: AppLayout,
    components: {
        Head,
        Link,
        AppLayout,
        Select2
    }
}
</script>

<style scoped>
form button {
    margin-top: 10px;
}
</style>
