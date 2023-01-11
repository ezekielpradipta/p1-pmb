import axiosClient from "../axios";
import router from "../router";
import { ref } from "vue";
export default function useAdminUser() {
    const users = ref([]);
    const user = ref([]);
    const getUsers = async (page, data) => {
        let url = "/admin/users?page=" + page;

        try {
            if (data) {
                let response = await axiosClient.post(url, data);
                users.value = response.data;
            } else {
                let response = await axiosClient.get(url);
                users.value = response.data;
            }
        } catch (error) {
            console.log(error);
        }
    };
    const getUser = async (id) => {
        let response = await axiosClient.post(`/admin/users/edit/${id}`);
        user.value = response.data;
    };

    const createUser = async (data) => {
        try {
            await axiosClient
                .post("/admin/user/save", data)
                .then((response) => {
                    if (!response.response) {
                        router.push({
                            name: "AdminUser",
                        });
                    }
                });
        } catch (error) {}
    };
    const deleteData = async (id) => {
        await axiosClient.post(`/admin/users/delete/${id}`);
    };
    const validData = async (id) => {
        await axiosClient.post(`/admin/users/valid/${id}`);
    };
    return {
        users,
        getUsers,
        createUser,
        user,
        getUser,
        deleteData,
        validData,
    };
}
