@extends('layouts.main')
@section('title',  'Gemini AI')
@section('content')
        <div class="gemini-data gemini-container gemini-main">
            <div class="main-chat-area">
                <div class="chat-content-wrapper gemini-chat-content-wrapper" style="background-color: var(--bg-main);">
                    <div id="chat-history" class=" space-y-4 relative">

                    </div>

                    <div id="greeting-div"
                        class="absolute inset-0 flex flex-col items-center text-center justify-center pointer-events-none">

                        <!-- <h1 class="text-3xl font-medium"> Meet </h1> -->
                        <div id="yoyo-user-name">

                        </div>
                    </div>

                    <div class="input-area-wrapper">
                        <div class="relative border-2 rounded-3xl px-6 pt-4 pb-12"
                            style="border-color: var(--border-color);">
                            <div id="image-preview-container" class="mb-2 relative hidden group w-fit">
                                <img id="image-preview" class="max-w-[100px] max-h-[100px] rounded-md" />
                                <button id="remove-preview"
                                    class="absolute top-1 right-1 w-8 h-8 text-2xl bg-black bg-opacity-60 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    &times;
                                </button>

                            </div>

                            <textarea id="user-input" placeholder="Ask YOYO"
                                class="w-full text-sm md:text-base font-medium bg-transparent resize-none overflow-y-auto max-h-[150px] focus:outline-none"
                                oninput="autoResize(this)" style="color: var(--text-main);">
                            </textarea>

                            <div
                                class="input-area-buttons flex justify-between items-center text-[var(--sidebar-text);]">
                                <div class="flex gap-2 text-sm items-center">
                                    <div class="relative">
                                        <button id="plus-button"
                                            class="group h-10 w-10 flex items-center justify-center rounded-full hover:bg-[var(--bg-hover)]">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24"
                                                width="24px" fill="currentColor">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                                            </svg>
                                        </button>

                                        <div id="plus-dropdown"
                                            class="hidden absolute py-2 left-0 bottom-full mb-2 w-48 rounded-lg shadow-lg z-50"
                                            style="background-color: var(--dropdown-bg); color: var(--dropdown-text);">
                                            <button id="trigger-upload"
                                                class="w-full text-left px-4 py-2 flex items-center gap-2 hover:bg-[var(--dropdown-hover)]">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                    viewBox="0 -960 960 960" width="20px" fill="currentColor">
                                                    <path
                                                        d="M696-312q0 89.86-63.07 152.93Q569.86-96 480-96q-91 0-153.5-65.5T264-319v-389q0-65 45.5-110.5T420-864q66 0 111 48t45 115v365q0 40.15-27.93 68.07Q520.15-240 480-240q-41 0-68.5-29.09T384-340v-380h72v384q0 10.4 6.8 17.2 6.8 6.8 17.2 6.8 10.4 0 17.2-6.8 6.8-6.8 6.8-17.2v-372q0-35-24.5-59.5T419.8-792q-35.19 0-59.5 25.5Q336-741 336-706v394q0 60 42 101.5T480-168q60 1 102-43t42-106v-403h72v408Z" />
                                                </svg>
                                                Upload files
                                            </button>
                                            <button
                                                class="w-full text-left px-4 py-2 flex items-center gap-2 hover:bg-[var(--dropdown-hover)]">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                    viewBox="0 -960 960 960" width="20px" fill="currentColor">
                                                    <path
                                                        d="M232-120q-17 0-31.5-8.5t-22.29-22.09L80.79-320.41Q73-334 73-351t8-31l248-427q8-14 22.5-22.5t31.06-8.5h194.88q16.56 0 31.06 8.5t22.42 22.37L811-500q-21-5-42-4.5t-42 4.5L571-768H389L146-351l92 159h337q11 21.17 25.5 39.59Q615-134 634-120H232Zm68-171-27-48 172.95-302H514l110 192q-14.32 13-26.53 28.5T576-388l-96-168-111 194h196q-6 17-9.5 34.7-3.5 17.71-3.5 36.3H300Zm432 147v-108H624v-72h108v-108h72v108h108v72H804v108h-72Z" />
                                                </svg>
                                                Add from Drive
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button id="send-button"
                                    class="group h-10 w-10 rounded-full flex items-center justify-center relative overflow-hidden transition-all duration-300 hover:bg-[var(--bg-hover)]">

                                    <span id="mic-icon"
                                        class="absolute transition-all duration-300 ease-in-out opacity-100 scale-100 translate-x-0">

                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="currentColor">
                                            <path
                                                d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z" />
                                        </svg>
                                    </span>

                                </button>
                            </div>
                            <input type="file" id="upload-preview-input" accept="image/*" class="hidden" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection