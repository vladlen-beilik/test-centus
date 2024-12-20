<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
// import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
// import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
// import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
// import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import AlertsForm from '@/Pages/Alerts/Partials/AlertsForm.vue';

defineProps({
    countries: {
        type: Array,
        default: () => [],
    }
});
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alerts
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <AlertsForm :user="$page.props.auth.user" :countries="$page.props.countries" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
