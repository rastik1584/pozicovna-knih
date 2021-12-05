import Vue from 'vue'
import VueRouter from 'vue-router'
import Books from "./components/Books.vue";
import Authors from "./components/Authors.vue";
import BookForm from "./components/BookForm";
import AuthorForm from "./components/AuthorForm";

Vue.use(VueRouter);
export default new VueRouter({
    mode: 'history',
    routes: [
        {
            name: 'Knihy',
            path: '/knihy',
            component: Books,
        },
        {
            name: 'Knihy formulár',
            path: '/knihy/form/:id?',
            component: BookForm,
        },
        {
            name: 'Autori',
            path: '/autori',
            component: Authors,
        },
        {
            name: 'Autori formulár',
            path: '/autori/form/:id?',
            component: AuthorForm,
        }
    ],
});
