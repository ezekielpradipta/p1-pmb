import { ref } from "vue";
import axiosClient from "../axios";
export default function useUtil() {
    const wilayah = ref([]);
    const cekEmail = async (data) => {
        try {
            let response = await axiosClient.post("/cek/email", data);
            return response;
        } catch (error) {}
    };
    const getWilayah = async (data) => {
        let response = await axiosClient.post("/getWilayah", data);
        wilayah.value = response.data;
    };
    return {
        cekEmail,
        wilayah,
        getWilayah,
    };
}
