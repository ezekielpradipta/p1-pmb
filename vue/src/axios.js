import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
import router from "./router";
const toaster = createToaster({
    position: "top-right",
    duration: 3000,
});
const axiosClient = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        "Content-type": "application/json",
    },
});
axiosClient.interceptors.request.use((config) => {
    const token = localStorage.getItem("token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});
axiosClient.interceptors.response.use(
    function (response) {
        console.log(response);
        const status = response.status;
        const message = response.data.message;
        if (status === 201) {
            toaster.success(message);
        }
        return response;
    },
    function (error) {
        console.log(error);
        const err_status = error.response.status;
        const err_message = error.response.data.message;
        const e_code = error.response.data.e_code;
        if (err_status === 500) {
            toaster.error(err_message);
        }
        if (err_status === 401) {
            toaster.error(err_status + ", " + err_message);
            localStorage.removeItem("token");
            router.push({ name: "Login" });
        }
        if (err_status === 400) {
            if (e_code === "10") {
                for (const [key, value] of Object.entries(err_message)) {
                    toaster.error(
                        "Error_status: " + e_code + ", " + `${value}`
                    );
                }
            }
            if (e_code === "11") {
                toaster.error("Error Status: " + e_code + ", " + err_message);
                router.push({ name: "Login" });
            }
            if (e_code === "12") {
                toaster.error("Error Status: " + e_code + ", " + err_message);
                router.push({ name: "ResetPassword" });
            }
            if (e_code === "13") {
                toaster.error("Error Status: " + e_code + ", " + err_message);
            }
        }
        return error;
    }
);
export default axiosClient;
