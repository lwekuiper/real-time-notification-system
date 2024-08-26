<script setup>
import { useNotificationsStore } from '@/stores/notifications';
import { storeToRefs } from 'pinia';

const store = useNotificationsStore();

const { unreadNotifications } = storeToRefs(store);
</script>

<template>
    <div class="absolute top-1/2 -translate-y-6 -right-3 h-6 w-6 flex justify-center items-center bg-red-500 text-xs rounded-full">
        <span class="text-white">{{ unreadNotifications.length }}</span>
    </div>
</template>
