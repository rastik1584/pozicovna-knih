<template>
    <Head title="Pozicovna knih" />
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import 'bootstrap/scss/bootstrap.scss'
import AppLayout from "@/Layouts/AppLayout";

export default defineComponent({
    components: {
        Head,
        Link,
    },
    layout: AppLayout
})
</script>

<style lang="scss" scoped>
    body {
        background: #333;
        margin: 0;
        padding: 0;
        h1 {
            display: flex;
            justify-content: center;
            font-weight: bold;
            font-size: 2.5em;
        }
        .headline-buttons {
            display: flex;
            flex-wrap: wrap;
            background: #333;
            height: 50px;
            color: #fff;
            .headline-btn {
                display: flex;
                justify-content: center;
                align-items: center;
                &:hover {
                    cursor: pointer;
                }
                &.active {
                    background: #999;
                }
            }
        }

    }

</style>


