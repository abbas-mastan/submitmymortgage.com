<div id="categoryModal" aria-hidden="true"
    class="hidden w-full h-full overflow-x-hidden overflow-y-auto fixed bg-gray-500 bg-opacity-40 z-50 justify-center items-center">
    <div style="margin-left:7rem"
        class="absolute mt-10 left-1/3 top-1/4 w-full max-w-2xl px-4 h-full md:h-auto bg-white shadow relative">
        <!-- Modal content -->
        <div class="">
            <!-- Modal header -->
            <div class="flex items-end pt-1 pr-1 ">
                <button id="modal-close" type="button"
                    class="addCategoryBtn text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-lg p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="default-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <form id="categoryForm">
                @csrf
                <div class="relative p-4 flex justify-center items-center py-1 ">
                    <div class="relative mb-3">
                        <label for="category">Category</label>
                        <input type="text" name="name" style="width: 33rem;"
                            class="peer block min-h-[auto]  rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="category" value="{{ old('name') }}" placeholder="Write Category Name" />
                            <span class="text-red-700"></span>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex  items-center justify-center pb-3  rounded-b dark:border-gray-600">
                    <input data-id="{{isset($user) ? $user->id : null}}" id="AddCategory" type="submit" value="Add Category"
                        class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white  rounded-lg text-sm px-8 py-2 text-center " />
                </div>
            </form>
        </div>
    </div>
</div>
