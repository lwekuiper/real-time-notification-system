<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

const notifications = ref([]);

const user = usePage().props.auth.user;

function sendNotification() {
    axios.post('/api/notify', {
        message: `Hello ${user.name}!`,
    })
    .then(response => {
        console.log('Notification sent!');
    })
    .catch(error => {
        console.error('Unable to send notification.', error);
    });
};

onMounted(() => {
    window.Echo.private(`notifications.${user.id}`)
        .listen('UserNotificationEvent', (e) => {
            notifications.value.push(e);
        });
});

onUnmounted(() => {
    window.Echo.leave(`notifications.${user.id}`);
});
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Notifcations</h2>

            <p class="mt-1 text-sm text-gray-600">
                Here are your notifications.
            </p>
        </header>

        <ul v-if="notifications.length > 0">
            <li v-for="(notification, index) in notifications" :key="index" class="grid grid-cols-2 border-b first:border-t py-2">
                <div>{{ notification.message }}</div>
                <div>{{ notification.timestamp }}</div>
            </li>
        </ul>

        <p v-else class="text-gray-600">
            No notifications yet.
        </p>

        <button
            @click="sendNotification"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
            Send Notification
        </button>
    </section>
</template>
