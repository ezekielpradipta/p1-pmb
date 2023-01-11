import { ref } from "vue";
import axiosClient from "../axios";
export default function useUtil() {
    const cekEmail = async (data) => {
        try {
            let response = await axiosClient.post("/cek/email", data);
            return response;
        } catch (error) {}
    };

    return {
        cekEmail,
    };
}
