// Create a new store instance.
const largeSidebar = {
    namespaced: true,
    state: {
        sidebarToggleProperties: {
            isSideNavOpen: true,
            isSecondarySideNavOpen: false,
        },
    },
    actions: {
        changeSecondarySidebarPropertiesViaMenuItem(
            { commit, state },
            payload = null
        ) {
            commit("changeSecondarySidebarProperties", {
                value:
                    payload !== null ? payload : !state.isSecondarySideNavOpen,
            });
        },
    },
    getters: {
        getSideBarToggleProperties: (state) => state.sidebarToggleProperties,
    },
    // we cant use async code ---commit
    mutations: {
        toggleSidebarProperties: (state) =>
            (state.sidebarToggleProperties.isSideNavOpen =
                !state.sidebarToggleProperties.isSideNavOpen),
        changeSecondarySidebarProperties: (state, payload) =>
            (state.sidebarToggleProperties.isSecondarySideNavOpen =
                payload.value),
    },
};

// const app = createApp({ /* your root component */ })

export default largeSidebar;
