import { ref } from "vue";
import axiosClient from "../axios";
export default function useUser() {
    const user = ref([]);
    const getUser = async () => {
        let response = await axiosClient.get("/user/cek");
        user.value = response.data;
    };
    const sendEmail = async () => {
        await axiosClient.post("/user/sendEmail");
    };
    return { user, getUser, sendEmail };
}
