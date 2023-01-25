import axiosClient from "../axios";
import router from "../router";
import { ref } from "vue";
export default function useAdminQuiz() {
    const jenisQuizs = ref([]);
    const jenisQuiz = ref([]);
    const getJenisQuizs = async (page) => {
        let url = "/admin/quiz/jenisQuiz?page=" + page;
        let response = await axiosClient.get(url);
        jenisQuizs.value = response.data;
    };
    const getJenisQuiz = async (id) => {
        let response = await axiosClient.post(
            `/admin/quiz/jenisQuiz/edit/${id}`
        );
        jenisQuiz.value = response.data;
    };
    const createJenisQuiz = async (data) => {
        try {
            await axiosClient
                .post("/admin/quiz/jenisQuiz/store", data)
                .then((response) => {
                    if (!response.response) {
                        router.push({
                            name: "AdminQuizJenisQuiz",
                        });
                    }
                });
        } catch (error) {}
    };
    const deleteJenisQuiz = async (id) => {
        await axiosClient.post(`/admin/quiz/jenisQuiz/delete/${id}`);
    };
    return {
        jenisQuiz,
        jenisQuizs,
        getJenisQuiz,
        getJenisQuizs,
        createJenisQuiz,
        deleteJenisQuiz,
    };
}
