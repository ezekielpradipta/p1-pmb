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
    const getWilayah = async () => {
        let response = await axiosClient.get("/getWilayah");

        wilayah.value = response.data;
    };
    return {
        cekEmail,
        wilayah,
        getWilayah,
    };
}
