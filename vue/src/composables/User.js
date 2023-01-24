import { ref } from "vue";
import axiosClient from "../axios";
export default function useUser() {
    const user = ref([]);
    const getUser = async () => {
        let response = await axiosClient.get("/user/cek");
        user.value = response.data;
    };
    const getDetailUser = async () => {
        let response = await axiosClient.get("/user/detail");
        user.value = response.data;
    };
    const sendEmail = async () => {
        await axiosClient.post("/user/sendEmail");
    };
    const save = async (data, config) => {
        try {
            await axiosClient
                .post("/user/saveDataDiri", data, config)
                .then((response) => {
                    if (!response.response) {
                        localStorage.removeItem("model-data-diri");
                    }
                });
        } catch (error) {}
    };
    return { user, getDetailUser, getUser, sendEmail, save };
}
