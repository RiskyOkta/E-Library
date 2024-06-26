<script>
export default {
    layout: AppLayout,
};
</script>
<script setup>
import axios from "axios";
import { notify } from "notiwind";
import { object, string } from "vue-types";
import { Head } from "@inertiajs/inertia-vue3";
import { ref, onMounted, reactive } from "vue";
import AppLayout from "@/layouts/apps.vue";
import debounce from "@/composables/debounce";
import VDropdownEditMenu from "@/components/VDropdownEditMenu/index.vue";
import VDataTable from "@/components/VDataTable/index.vue";
import VPagination from "@/components/VPagination/index.vue";
import VBreadcrumb from "@/components/VBreadcrumb/index.vue";
import VLoading from "@/components/VLoading/index.vue";
import VEmpty from "@/components/src/icons/VEmpty.vue";
import VButton from "@/components/VButton/index.vue";
import VAlert from "@/components/VAlert/index.vue";
import VEdit from "@/components/src/icons/VEdit.vue";
import VTrash from "@/components/src/icons/VTrash.vue";
import VRead from "@/components/src/icons/VRead.vue";
import VFilter from "./Filter.vue";
import VModalForm from "./ModalForm.vue";

const query = ref([]);
const searchFilter = ref("");
const filter = ref({});
const breadcrumb = [
    {
        name: "Dashboard",
        active: false,
        to: route("dashboard.index"),
    },
    {
        name: "Book",
        active: true,
        to: route("book.index"),
    },
];
const pagination = ref({
    count: "",
    current_page: 1,
    per_page: "",
    total: 0,
    total_pages: 1,
});
const alertData = reactive({
    headerLabel: "",
    contentLabel: "",
    closeLabel: "",
    submitLabel: "",
});
const updateAction = ref(false);
const itemSelected = ref({});
const openAlert = ref(false);
const openModalForm = ref(false);
const heads = [
    "Book Title",
    "Book Number",
    "Location",
    "Departemen",
    "Fungsi",
    "Scan",
    "",
];
const isLoading = ref(true);
const props = defineProps({
    title: string(),
    additional: object(),
});

const getData = debounce(async (page) => {
    axios
        .get(route("book.getdata"), {
            params: {
                page: page,
                search: searchFilter.value,
                filter_category: filter.value.filter_category,
                filter_utility: filter.value.filter_utility,
            },
        })
        .then((res) => {
            query.value = res.data.data;
            pagination.value = res.data.meta.pagination;
        })
        .catch((res) => {
            notify(
                {
                    type: "error",
                    group: "top",
                    text: res.response.data.message,
                },
                2500
            );
        })
        .finally(() => (isLoading.value = false));
}, 500);

const nextPaginate = () => {
    pagination.value.current_page += 1;
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const previousPaginate = () => {
    pagination.value.current_page -= 1;
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const searchHandle = (search) => {
    searchFilter.value = search;
    isLoading.value = true;
    getData(1);
};

const applyFilter = (data) => {
    filter.value = data;
    isLoading.value = true;
    getData(1);
};

const clearFilter = (data) => {
    filter.value = data;
    isLoading.value = true;
    getData(1);
};

const handleAddModalForm = () => {
    updateAction.value = false;
    openModalForm.value = true;
};

const handleEditModal = (data) => {
    updateAction.value = true;
    itemSelected.value = data;
    openModalForm.value = true;
};

const successSubmit = () => {
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const closeModalForm = () => {
    itemSelected.value = ref({});
    openModalForm.value = false;
};

const alertDelete = (data) => {
    itemSelected.value = data;
    openAlert.value = true;
    alertData.headerLabel = "Are you sure to delete this?";
    alertData.contentLabel = "You won't be able to revert this!";
    alertData.closeLabel = "Cancel";
    alertData.submitLabel = "Delete";
};

const closeAlert = () => {
    itemSelected.value = ref({});
    openAlert.value = false;
};

function openFile(filePath) {
    window.open(filePath, "_blank");
}

const deleteHandle = async () => {
    axios
        .delete(route("book.delete", { id: itemSelected.value.id }))
        .then((res) => {
            notify(
                {
                    type: "success",
                    group: "top",
                    text: res.data.meta.message,
                },
                2500
            );
            openAlert.value = false;
            isLoading.value = true;
            getData(pagination.value.current_page);
        })
        .catch((res) => {
            notify(
                {
                    type: "error",
                    group: "top",
                    text: res.response.data.message,
                },
                2500
            );
        });
};

const exportHandle = async () => {
    try {
        const response = await axios.get("book/exportBook");
        console.log(response.data);
    } catch (error) {
        console.error("Error exporting books:", error);
    }
};

onMounted(() => {
    getData(1);
});
</script>

<template>
    <Head :title="props.title" />
    <VBreadcrumb :routes="breadcrumb" />
    <div class="mb-4 sm:mb-6 flex justify-between items-center">
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Book List</h1>
    </div>
    <div
        class="bg-white shadow-lg rounded-sm border border-slate-200"
        :class="isLoading && 'min-h-[40vh] sm:min-h-[50vh]'"
    >
        <header class="block justify-between items-center sm:flex py-6 px-4">
            <h2 class="font-semibold text-slate-800">
                All Books
                <span class="text-slate-400 !font-medium ml">{{
                    pagination.total
                }}</span>
            </h2>
            <div
                class="mt-3 sm:mt-0 flex space-x-2 sm:justify-between justify-end"
            >
                <!-- Filter -->
                <VFilter
                    @search="searchHandle"
                    @apply="applyFilter"
                    @clear="clearFilter"
                    :additional="additional"
                />
                <a
                    type="button"
                    href="/admin/book/exportBook"
                    download="book.xlsx"
                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-sm text-sm px-5 pt-2 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                >
                    Export
                </a>
                <VButton
                    label="Add Book"
                    type="primary"
                    @click="handleAddModalForm"
                    class="mt-auto"
                />
            </div>
        </header>

        <VDataTable :heads="heads" :isLoading="isLoading">
            <tr v-if="isLoading">
                <td
                    class="h-[100%] overflow-hidden my-2"
                    :colspan="heads.length"
                >
                    <VLoading />
                </td>
            </tr>
            <tr v-else-if="query.length === 0 && !isLoading">
                <td class="overflow-hidden my-2" :colspan="heads.length">
                    <div class="flex items-center flex-col w-full my-32">
                        <VEmpty />
                        <div
                            class="mt-9 text-slate-500 text-xl md:text-xl font-medium"
                        >
                            Result not found.
                        </div>
                    </div>
                </td>
            </tr>
            <tr v-for="(data, index) in query" :key="index" v-else>
                <td class="px-4 whitespace-nowrap h-16">
                    {{ data.book_title }}
                </td>
                <td class="px-4 whitespace-nowrap h-16">
                    {{ data.book_number }}
                </td>
                <td class="px-4 whitespace-nowrap h-16">{{ data.location }}</td>
                <td class="px-4 whitespace-nowrap h-16">
                    <p>{{ data.name }}</p>
                    <p>{{ data.category_name }}</p>
                </td>
                <td class="px-4 whitespace-nowrap h-16">
                    <p>{{ data.name }}</p>
                    <p>{{ data.utility_name }}</p>
                </td>
                <td class="px-4 whitespace-nowrap h-16">{{ data.is_scan }}</td>

                <td class="px-4 whitespace-nowrap h-16 text-right">
                    <VDropdownEditMenu
                        :align="'right'"
                        :last="index === query.length - 1 ? true : false"
                    >
                        <li
                            class="cursor-pointer hover:bg-slate-100"
                            @click="openFile(data.file_path_url)"
                        >
                            <div
                                class="flex justify-between items-center space-x-2 p-3"
                            >
                                <span>
                                    <VRead color="primary" />
                                </span>
                                <span>View</span>
                            </div>
                        </li>
                        <li
                            class="cursor-pointer hover:bg-slate-100"
                            @click="handleEditModal(data)"
                        >
                            <div class="flex items-center space-x-2 p-3">
                                <span>
                                    <VEdit color="primary" />
                                </span>
                                <span>Edit</span>
                            </div>
                        </li>
                        <li class="cursor-pointer hover:bg-slate-100">
                            <div
                                class="flex justify-between items-center space-x-2 p-3"
                                @click="alertDelete(data)"
                            >
                                <span>
                                    <VTrash color="danger" />
                                </span>
                                <span>Delete</span>
                            </div>
                        </li>
                    </VDropdownEditMenu>
                </td>
            </tr>
        </VDataTable>
        <div class="px-4 py-6">
            <VPagination
                :pagination="pagination"
                @next="nextPaginate"
                @previous="previousPaginate"
            />
        </div>
    </div>
    <VAlert
        :open-dialog="openAlert"
        @closeAlert="closeAlert"
        @submitAlert="deleteHandle"
        type="danger"
        :headerLabel="alertData.headerLabel"
        :content-label="alertData.contentLabel"
        :close-label="alertData.closeLabel"
        :submit-label="alertData.submitLabel"
    />
    <VModalForm
        :data="itemSelected"
        :update-action="updateAction"
        :open-dialog="openModalForm"
        @close="closeModalForm"
        @successSubmit="successSubmit"
        :additional="additional"
    />
</template>
