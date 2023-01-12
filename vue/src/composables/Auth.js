import axiosClient from "../axios";
import jwt_decode from "jwt-decode";
import router from "../router";
import { createToaster } from "@meforma/vue-toaster";
export default function useAuth() {
    const toaster = createToaster({
        position: "top-right",
        duration: 3000,
    });
    const login = async (data) => {
        await axiosClient
            .post("/login", data)
            .then((response) => {
                if (!response.response) {
                    localStorage.setItem("token", response.data.token);
                    let token = jwt_decode(response.data.token);
                    let userRole = token.user.roles[0].role_name;
                    if (userRole === "user") {
                        router.push({
                            name: "User",
                        });
                    } else if (userRole === "admin") {
                        router.push({
                            name: "Admin",
                        });
                    }
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const logout = async () => {
        let coba = await axiosClient.post("/logout");
        console.log(coba);
        localStorage.removeItem("token");
        router.push({
            name: "Login",
        });
    };
    const register = async (data) => {
        let response = await axiosClient
            .post("/register", data)
            .then((response) => {
                console.log(response);
                if (!response.response) {
                    login(data);
                }
            });
    };
    const sendToken = async (data) => {
        await axiosClient.post("/sendToken", data).then((response) => {});
    };
    const sendEmailVerif = async (data) => {
        await axiosClient.post("/sendEmailVerif", data);
    };
    const validateToken = async (data) => {
        await axiosClient.post("/validateToken", data).then((response) => {
            if (response.status === 200) {
                let cobastring =
                    "email+" + response.data.email + "+" + data.token;
                let decode64 = btoa(cobastring);
                let generateUrl = decode64 + "??new-password";
                router.push({
                    name: "NewPassword",
                    params: { id: generateUrl },
                });
            }
        });
    };
    const resetPassword = async (id) => {
        let response = await axiosClient.post(`/resetPassword/${id}`);
    };
    const newPassword = async (data, id) => {
        let response = await axiosClient.post(`/newPassword/${id}`, data);
        router.push({
            name: "Login",
        });
    };
    const verifEmail = async (id) => {
        let response = await axiosClient.post(`/akun/verif-email/${id}`);
        toaster.success(
            "Akun Anda Berhasil Terverifikasi, Silahkan Login Ulang"
        );
        logout();
    };
    return {
        login,
        logout,
        register,
        sendToken,
        validateToken,
        resetPassword,
        newPassword,
        sendEmailVerif,
        verifEmail,
    };
}
