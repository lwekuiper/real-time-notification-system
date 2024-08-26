<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const notificationCount = ref(0);

const user = usePage().props.auth.user;

onMounted(async () => {
    window.Echo.private(`notifications.${user.id}`)
        .listen('UserNotificationEvent', () => {
            notificationCount.value++;
        });
});

onUnmounted(() => {
    window.Echo.leave(`notifications.${user.id}`);
});
</script>

<template>
    <div class="absolute top-1/2 -translate-y-6 -right-3 h-6 w-6 flex justify-center items-center bg-red-500 text-xs rounded-full">
        <span class="text-white">{{ notificationCount }}</span>
    </div>
</template>
