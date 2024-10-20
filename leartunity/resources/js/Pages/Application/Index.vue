<template>
<Layout>
    <div class="send-application container mx-auto mt-8">
        <form v-if="!application || isCooldownFinished" @submit.prevent="apply" enctype="multipart/form-data" method="POST" style="display: inline;">
            <label for="fullname">
                <p>Fullname</p>
                <p class="text-red-500 text-xs">{{ $page.props.errors?.fullname }}</p>
                <input type="text" class="mb-3" v-model="form.fullname" name="fullname" id="fullname">
            </label>
            <label for="age">
                <p>Cover Letter</p>
                <p class="text-red-500 text-xs">{{ $page.props.errors?.cover_letter }}</p>
                <textarea name="cover_letter" v-model="form.cover_letter" id="cover_letter" style="resize: none; height: 100px;" class="w-1/2"></textarea>
            </label>
            <label for="qualification">
                <p>Qualification</p>
                <p class="text-red-500 text-xs">{{ $page.props.errors?.qualification }}</p>
                <select name="qualification" v-model="form.qualification" class="w-1/2 px-2 mb-3" style="height: 35px" id="qualification">
                    <option :value="index" v-for="(qualification, index) in qualifications" :key="index" style="text-transform: capitalize;">{{ qualification[0] + qualification.substring(1).toLowerCase() }}</option>
                </select>
            </label>
            <label for="supporting-file">
                <p>Supporting File (Optional) (Max 2MB)</p>
                <p class="text-red-500 text-xs">{{ $page.props.errors?.supporting_file }}</p>
                <input type="file" @change="uploadFile" name="supporting_file" class="mb-3" id="supporting-file">
            </label>
            <p class="text-red-500 text-xs">{{ $page.props.errors?.read_conditions }}</p>
            <label for="t&c" class="mb-3 flex items-center">
                <input type="checkbox" style="margin: 0px" v-model="form.read_conditions" name="read_conditions" class="mb-3" id="read_conditions">
                <p style="padding: 0px;" class="ml-3">I have read Terms and Conditions.</p>
            </label>
            <input type="submit" style="border-radius: 0px; cursor: pointer;" class="mb-3" value="Submit">
        </form>
        <div v-else-if="application.status === 0" class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
            Your Application is Pending!
        </div>
        <div v-else-if="application.status === 1" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            Your Application has been approved! You can start making course now...
        </div>
        <div v-else class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            Your Application has been rejected! You can apply again at {{ moment(application.cooldown_till).format("D-MMMM-YYYY h:mm a") }}
        </div>


    </div>
</Layout>

</template>
<script setup>

import Layout from "../../Shared/Layout.vue";
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { onMounted, computed } from "vue";
import moment from "moment";

const props = defineProps({
    qualifications: Array,
    application: Array
});

onMounted(() => {
    console.log(props.application);
})

const isRejected = computed(() => props.application?.status === 2);
const isCooldownFinished = computed(() => props.application.status === 2 && moment(props.application.cooldown_till).diff(moment(), 'seconds') <= 0);

const page = usePage();

const form = useForm({
    fullname: "",
    cover_letter: "",
    qualification: 0,
    read_conditions: false,
    supporting_file: '',
    _method: props.application ? "PUT" : "POST"
});


const maxSize = 2; // In MB

const uploadFile = e => {
    const file = e.target.files[0];
    const fileSize = file.size / (1024 * 1024);
    if(fileSize > maxSize) {
        page.props.errors.supporting_file = "File size must not exceed more than 2MB";
        return;
    }
    form.supporting_file = file;
}

const apply = async () => {
    const status = form.post(
        route(isRejected.value ? "application.update" : "application.create", { onSuccess: () => form.reset() })
    )
}
</script>
