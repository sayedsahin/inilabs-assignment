import { defineStore } from "pinia";
import api from "../api/axios";

export const useAuthStore = defineStore("auth", {
	state: () => ({
		user: null,
		token: localStorage.getItem("token") || null,
		loadingUser: true, // used during reload
	}),

	getters: {
		isAuthenticated: (state) => !!state.token,
	},

	actions: {
		async login(credentials) {
			const res = await api.post("/login", credentials);

			this.token = res.data.token;
			localStorage.setItem("token", res.data.token);

			this.user = res.data.user;
		},

		async logout() {
			try {
				await api.post("/logout");
			} catch (err) {
			  // error message in console
			  console.error("Logout failed:", err);

			}

			this.user = null;
			this.token = null;
			localStorage.removeItem("token");
		},

		async fetchUser() {
        if (!this.token) return;

        try {
            const res = await api.get("/user");
            this.user = res.data;
        } catch {
            this.logout();
        }
    },
	},
});
