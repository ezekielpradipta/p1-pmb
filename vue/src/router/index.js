import { createRouter, createWebHistory } from "vue-router";
import jwt_decode from "jwt-decode";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({
    position: "top-right",
    duration: 3000,
});
const routes = [
    {
        path: "/auth",
        redirect: "/login",
        name: "Auth",
        component: () => import("../views/layouts/AuthLayout.vue"),
        meta: { isGuest: true },
        children: [
            {
                path: "/login",
                name: "Login",
                component: () => import("../views/Login.vue"),
            },
            {
                path: "/register",
                name: "Register",
                component: () => import("../views/Register.vue"),
            },
            {
                path: "/reset-password",
                name: "ResetPassword",
                component: () => import("../views/ResetPassword.vue"),
            },
            {
                path: "/new-password/:id",
                name: "NewPassword",
                component: () => import("../views/NewPassword.vue"),
            },
        ],
    },
    {
        path: "/verif-email/:id",
        name: "VerifEmail",
        component: () => import("../views/VerifEmail.vue"),
        meta: {
            isUser: true,
        },
    },
    {
        path: "/",
        meta: { requiresAuth: true },
        redirect: "/user",
        component: () => import("../views/layouts/Index.vue"),
        children: [
            {
                path: "/user",
                name: "User",
                component: () => import("../views/pages/users/Dashboard.vue"),
                meta: {
                    isUser: true,
                },
            },
            {
                path: "/datadiri",
                name: "DataDiri",
                component: () => import("../views/forms/UserDataDiriForm.vue"),
                meta: {
                    isUser: true,
                    isValid: true,
                },
            },
            {
                path: "/admin",
                name: "Admin",
                component: () => import("../views/pages/admins/Dashboard.vue"),
                meta: {
                    isAdmin: true,
                },
            },
            {
                path: "/admin/logs",
                name: "LogUsers",
                component: () => import("../views/pages/admins/LogUser.vue"),
                meta: {
                    isAdmin: true,
                },
            },
            {
                path: "/admin/users",
                name: "AdminUser",
                component: () => import("../views/pages/admins/AdminUser.vue"),
                meta: {
                    isAdmin: true,
                },
            },
            {
                path: "/admin/users/create",
                name: "AdminUserForm",
                component: () => import("../views/forms/AdminUserForm.vue"),
                meta: {
                    isAdmin: true,
                },
            },
            {
                path: "/admin/users/edit/:id",
                name: "AdminUserView",
                component: () => import("../views/forms/AdminUserForm.vue"),
                meta: {
                    isAdmin: true,
                },
            },
        ],
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from, next) => {
    if (localStorage.token) {
        try {
            let gtToken = localStorage.getItem("token");
            let dcd = jwt_decode(gtToken);
            let roles = dcd.user.roles.map((role) => role.role_name);
            if (to.matched.some((record) => record.meta.isGuest)) {
                if (roles[0] === "user") {
                    next({
                        name: "User",
                    });
                    return;
                } else if (roles[0] === "admin") {
                    next({
                        name: "Admin",
                    });
                    return;
                }
            }
        } catch (error) {
            if (error.message === "Invalid token specified: e2 is undefined") {
                toaster.error(
                    "ERROR, Format Token Berubah, Anda Perlu Login Ulang"
                );
                localStorage.removeItem("token");
            }
        }
    }

    if (to.matched.some((record) => record.meta.isValid)) {
        let gtToken = localStorage.getItem("token");
        let dcd = jwt_decode(gtToken);
        let validasi = dcd.user.is_valid;
        if (validasi === "1") {
            next();
            return;
        } else if (validasi === "0") {
            toaster.error("Perlu Mengaktifkan Akun Terlebih Dahulu");
            next({
                name: "User",
            });
            return;
        }
    }

    if (to.matched.some((record) => record.meta.requiresAuth)) {
        let token = localStorage.getItem("token") != null;
        if (!token) {
            next({
                path: "/login",
                query: {
                    redirect: to.fullPath,
                },
            });
            return;
        } else {
            let gtToken = localStorage.getItem("token");
            let dcd = jwt_decode(gtToken);
            let validasi = dcd.user.is_valid;
            let roles = dcd.user.roles.map((role) => role.role_name);
            if (to.matched.some((record) => record.meta.isUser)) {
                if (roles.includes("user")) next();
                else if (roles[0] === "admin") {
                    next({
                        name: "Admin",
                    });
                }
            } else if (to.matched.some((record) => record.meta.isAdmin)) {
                if (roles.includes("admin")) next();
                else if (roles[0] === "user") {
                    next({
                        name: "User",
                    });
                }
            }
        }
    } else {
        next();
    }
});
export default router;
