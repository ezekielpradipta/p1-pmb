import axiosClient from "../axios";
import { ref } from "vue";
export default function useLogsUser() {
    const logs = ref([]);
    const filterList = ref([]);
    const getLogs = async (page, data) => {
        let url = "/admin/logsuser?page=" + page;
        try {
            if (data) {
                let response = await axiosClient.post(url, data);
                logs.value = response.data;
            } else {
                let response = await axiosClient.get(url);
                logs.value = response.data;
            }
        } catch (error) {
            console.log(error.message);
        }
    };
    const getFilter = async (data) => {
        let response = await axiosClient.get("/admin/logsuser/getFilter");
        filterList.value = response.data;
    };
    const exportLog = async () => {
        try {
            let ini = await axiosClient
                .get("/admin/logsuser/export", {
                    responseType: "blob",
                })
                .then((response) => {
                    var fileURL = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    var fileLink = document.createElement("a");
                    fileLink.href = fileURL;
                    fileLink.setAttribute("download", "Data-Log.xlsx");
                    document.body.appendChild(fileLink);
                    fileLink.click();
                });
        } catch (error) {}
    };
    return {
        logs,
        getLogs,
        filterList,
        getFilter,
        exportLog,
    };
}
