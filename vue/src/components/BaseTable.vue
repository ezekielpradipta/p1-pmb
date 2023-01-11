<template>
  <div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <thead
          class="
            text-xs
            font-semibold
            tracking-wide
            text-left text-gray-500
            uppercase
            border-b
            dark:border-gray-50
            bg-gray-50
            dark:text-gray-300 dark:bg-dark-new
          "
        >
          <th
            scope="col"
            class="
              px-6
              py-3
              bg-white
              divide-y
              dark:text-gray-300 dark:bg-dark-new
            "
            v-for="{ key, label, sortable } in headers"
            :key="key"
          >
            {{ label }}
          </th>
        </thead>
        <tbody v-if="props.items.length == 0">
          <tr>
            Data Tidak Ditemukan
          </tr>
        </tbody>
        <tbody v-else class="mb-4 bg-white dark:text-gray-300 dark:bg-dark-new">
          <tr
            v-for="(p, index) in props.items"
            :key="index"
            class="
              text-gray-700
              dark:text-gray-400
              hover:bg-blue-50
              dark:hover:bg-dark-body-new
            "
          >
            <td
              v-for="{ key, label, route, prkey, moreView } in headers"
              :key="key"
              class="px-6 py-4"
            >
              <div v-if="moreView">
                <div v-if="moreView == 'Aksi-Full'">
                  <slot :name="`(${key})`" :value="p[key]" :item="p">
                    <div class="flex items-center space-x-4 text-sm">
                      <button
                        @click="
                          router.push({ name: route, params: { id: p[key] } })
                        "
                        class="
                          flex
                          items-center
                          justify-between
                          px-2
                          py-2
                          text-sm
                          font-medium
                          leading-5
                          text-blue-600
                          rounded-lg
                          dark:text-gray-400
                          focus:outline-none focus:shadow-outline-gray
                        "
                        aria-label="Edit"
                      >
                        <svg
                          class="w-5 h-5"
                          aria-hidden="true"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                          ></path>
                        </svg>
                      </button>
                      <button
                        @click="deleteThis(p[key])"
                        class="
                          flex
                          items-center
                          justify-between
                          px-2
                          py-2
                          text-sm
                          font-medium
                          leading-5
                          text-blue-600
                          rounded-lg
                          dark:text-gray-400
                          focus:outline-none focus:shadow-outline-gray
                        "
                        aria-label="Delete"
                      >
                        <svg
                          class="w-5 h-5"
                          aria-hidden="true"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </button>
                    </div>
                  </slot>
                </div>
                <div v-if="moreView == 'Validasi'">
                  <div v-if="p[key] == 1">
                    <slot :name="`(${key})`" :value="p[key]" :item="p">
                      <span
                        class="
                          text-sm
                          px-2
                          py-1
                          font-semibold
                          leading-tight
                          text-green-700
                          bg-green-100
                          dark:bg-green-700 dark:text-green-100
                        "
                      >
                        Valid
                      </span></slot
                    >
                  </div>
                  <div v-else>
                    <slot :name="`(${key})`" :value="p[key]" :item="p">
                      <button @click="validthis(p[prkey])">
                        <span
                          class="
                            text-sm
                            px-2
                            py-1
                            font-semibold
                            leading-tight
                            text-red-700
                            bg-red-100
                            dark:text-red-100 dark:bg-red-700
                          "
                        >
                          Belum Valid
                        </span>
                      </button>
                    </slot>
                  </div>
                </div>
              </div>

              <div v-else>
                <slot :name="`(${key})`" :value="p[key]" :item="p">
                  {{ p[key] }}
                </slot>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Pagination -->
  <div
    class="
      bg-white
      px-4
      py-3
      flex
      items-center
      justify-between
      sm:px-6
      mt-4
      dark:bg-dark-new
    "
  >
    <div class="flex-1 flex justify-between sm:hidden">
      <a
        href="#"
        @click.prevent="onClickPreviousPage"
        :class="hitung.isInFirstPage ? 'disabled' : ''"
        :disabled="hitung.isInFirstPage"
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          hover:bg-gray-50
          dark:bg-gray-800
        "
      >
        Previous
      </a>
      <a
        href="#"
        @click.prevent="onClickNextPage"
        :class="hitung.isInLastPage ? 'disabled' : ''"
        :disabled="hitung.isInLastPage"
        class="
          ml-3
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          hover:bg-gray-50
          dark:divide-gray-700 dark:bg-gray-800
        "
      >
        Next
      </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
      <div>
        <nav
          class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <a
            href="#"
            @click.prevent="onClickPreviousPage"
            :class="hitung.isInFirstPage ? 'disabled' : ''"
            :disabled="hitung.isInFirstPage"
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              rounded-l-md
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
              dark:text-gray-300 dark:bg-dark-body-new dark:border-dark-new
            "
          >
            <span class="sr-only">Previous</span>
            <!-- Heroicon name: solid/chevron-left -->
            <svg
              class="h-5 w-5"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
          <li :key="page.id" v-for="page in hitung.pages">
            <a
              href="#"
              @click.prevent="onClickPage(page.name)"
              :disabled="page.isDisabled"
              :class="{
                'z-10  text-blue-500 dark:text-white dark:bg-blue-500 inline-flex px-4 py-2':
                  isPageActive(page.name),
              }"
              class="
                bg-white
                border-gray-300
                text-gray-500
                hover:bg-gray-50
                relative
                inline-flex
                items-center
                px-4
                py-2
                border
                text-sm
                font-medium
                dark:text-gray-300 dark:bg-dark-body-new dark:border-dark-new
              "
            >
              {{ page.name }}
            </a>
          </li>
          <li v-if="!hitung.isInLastPage && props.totalPages - 1">
            <a
              href="#"
              @click.prevent="onClickPage(props.totalPages)"
              :disabled="hitung.isInLastPage"
              :class="{
                'z-10 border-purple-500 text-purple-500 inline-flex px-4 py-2':
                  isPageActive(props.totalPages),
              }"
              class="
                bg-white
                border-gray-300
                text-gray-500
                hover:bg-gray-50
                relative
                inline-flex
                items-center
                px-4
                py-2
                border
                text-sm
                font-medium
                dark:text-gray-300 dark:bg-dark-body-new dark:border-dark-new
              "
            >
              {{ props.totalPages }}
            </a>
          </li>
          <a
            href="#"
            @click.prevent="onClickNextPage"
            :class="hitung.isInLastPage ? 'disabled' : ''"
            :disabled="hitung.isInLastPage"
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              rounded-r-md
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
              dark:text-gray-300 dark:bg-dark-body-new dark:border-dark-new
            "
          >
            <span class="sr-only">Next</span>
            <!-- Heroicon name: solid/chevron-right -->
            <svg
              class="h-5 w-5"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
        </nav>
      </div>
    </div>
  </div>
  Halaman {{ props.pages }} dari {{ props.totalPages }}
</template>

<script setup>
import { computed, reactive, watch, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const props = defineProps({
  headers: {
    type: Array,
    required: true,
  },
  items: {
    type: Array,
    required: true,
  },
  pages: {
    type: Number,
    required: true,
  },
  pageSize: {
    type: Number,
    required: true,
  },
  maxVisibleButtons: {
    type: Number,
    required: false,
    default: 3,
  },
  totalPages: {
    type: Number,
    required: true,
  },
});
//Per page = pageSize
//current page = pages
const emit = defineEmits(["pagechanged", "delete", "valid"]);
const hitung = reactive({
  isInFirstPage: computed(() => {
    return props.pages === 1;
  }),
  isInLastPage: computed(() => {
    if (props.totalPages === 0) {
      return true;
    }
    return props.pages === props.totalPages;
  }),
  endPage: computed(() => {
    if (props.totalPages === 0) {
      return 1;
    }
    if (props.totalPages < props.maxVisibleButtons) {
      return props.totalPages;
    }
    return Math.min(
      hitung.startPage + props.maxVisibleButtons - 1,
      props.totalPages
    );
  }),
  startPage: computed(() => {
    //page1
    if (props.pages === 1) {
      return 1;
    }
    //page akhir
    if (props.totalPages < props.maxVisibleButtons) {
      return 1;
    }
    if (props.pages === props.totalPages) {
      return props.totalPages - props.maxVisibleButtons + 1;
    }
    //page bukan 1
    return props.pages - 1;
  }),
  pages: computed(() => {
    const range = [];
    for (let i = hitung.startPage; i <= hitung.endPage; i++) {
      range.push({
        name: i,
        isDisabled: i === props.pages,
      });
    }
    return range;
  }),
});
function paginated() {
  return props.items.slice(
    (props.pages - 1) * props.pageSize,
    (props.pages - 1) * props.pageSize + props.pageSize
  );
}

function onClickFirstPage() {
  if (hitung.isInFirstPage) {
    return false;
  }
  emit("pagechanged", 1);
}
function onClickPreviousPage() {
  if (hitung.isInFirstPage) {
    return false;
  }
  emit("pagechanged", props.pages - 1);
}
function onClickPage(page) {
  emit("pagechanged", page);
}
function onClickNextPage() {
  if (hitung.isInLastPage) {
    return false;
  }
  emit("pagechanged", props.pages + 1);
}
function onClickLastPage() {
  if (hitung.isInLastPage) {
    return false;
  }
  emit("pagechanged", props.totalPages);
}
function isPageActive(page) {
  return props.pages === page;
}
function deleteThis(e) {
  emit("delete", e);
}
function validthis(e) {
  emit("valid", e);
}
</script>

<style lang="scss" scoped>
</style>