<script>
export default {
    layout: AppLayout,
};
</script>
<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { array, object, string } from "vue-types";
import AppLayout from "@/layouts/apps.vue";

const props = defineProps({
    filter: object(),
    query: array(),
    modules: array(),
    title: string(),
    totalBooks: object(),
    totalCategories: object(),
    totalRoles: object(),
    totalUsers: object(),
    totalUtilities: object(),
});
</script>

<template>
    <Head :title="props.title" />
    <div class="mb-4 sm:mb-6 flex justify-between items-center">
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
            Welcome, Admin
        </h1>
    </div>

    <div class="grid grid-cols-4 xxl:grid-cols-4 xl:grid-cols-4 gap-4">
        <div>
            <a
                href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-success  dark:hover:bg-gray-700"
            >
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    Total Books
                </h5>
                <div class="text-4xl text-gray-700 dark:text-gray-100">

                     <button class="btn btn-lg">  {{ props.totalBooks }}</button></div>
            </a>
        </div>

        <div>
            <a
                href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-teal-500  dark:hover:bg-gray-700"
            >
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    Total Categories
                </h5>
                <div class="text-4xl text-gray-700 dark:text-gray-100">

                     <button class="btn btn-lg  hover:text-dark">  {{ props.totalCategories }}</button></div>
            </a>
        </div>

        <div>
            <a
                href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-sky-400   dark:hover:bg-gray-700"
            >
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    Total Roles
                </h5>
                <div class="text-4xl text-gray-700 dark:text-gray-100">

                     <button class="btn btn-lg">  {{ props.totalRoles }}</button></div>
            </a>
        </div>

        <div>
            <a
                href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-blue-400   dark:hover:bg-gray-700"
            >
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    Total Users
                </h5>
                <div class="text-4xl text-gray-700 dark:text-gray-100">

                     <button class="btn btn-lg">  {{ props.totalUsers }}</button></div>
            </a>
        </div>

        <div>
            <a
                href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800   dark:hover:bg-gray-700"
            >
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    Total Utilities
                </h5>
                <div class="text-4xl text-gray-700 dark:text-gray-100">

                     <button class="btn btn-lg">  {{ props.totalUtilities }}</button></div>
            </a>
        </div>

    </div>
</template>
