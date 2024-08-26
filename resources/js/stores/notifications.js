import { defineStore } from 'pinia';

export const useNotificationsStore = defineStore('notifications', {
    state: () => ({
        /** @type {{ message: string, timestamp: string, read: boolean }[]} */
        notifications: [],
    }),
    getters: {
        unreadNotifications: (state) => state.notifications.filter(notification => !notification.read),
    },
    actions: {
        addNotification(message, timestamp) {
            this.notifications.push({ message, timestamp, read: false });
        },
        toggleRead(index) {
            this.notifications[index].read = !this.notifications[index].read;
        }
    },
});
