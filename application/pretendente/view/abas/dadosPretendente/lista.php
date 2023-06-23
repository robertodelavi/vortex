<div>
    <form class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 mb-5 bg-white dark:bg-[#0e1726]">
        <h6 class="text-lg font-bold mb-5">Dados Gerais</h6>
        <div class="flex flex-col sm:flex-row">

            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name">Nome do Pretendente</label>
                    <input name="nome" id="name" type="text" placeholder="Jimmy Turner" class="form-input" />
                </div>
                <div>
                    <label for="email">E-mail</label>
                    <input name="email" id="email" type="email" placeholder="fulano@email.com" class="form-input" />
                </div>
                <div>
                    <label for="country">Sexo</label>
                    <select id="country" class="form-select text-white-dark">
                        <option selected="">Masculino</option>
                        <option>Feminino</option>
                    </select>
                </div>
                <div>
                    <label for="address">Address</label>
                    <input id="address" type="text" placeholder="New York" class="form-input" />
                </div>
                <div>
                    <label for="location">Location</label>
                    <input id="location" type="text" placeholder="Location" class="form-input" />
                </div>
                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" type="text" placeholder="+1 (530) 555-12121" class="form-input" />
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" placeholder="Jimmy@gmail.com" class="form-input" />
                </div>
                <div>
                    <label for="web">Website</label>
                    <input id="web" type="text" placeholder="Enter URL" class="form-input" />
                </div>
                <div>
                    <label class="inline-flex cursor-pointer">
                        <input type="checkbox" class="form-checkbox" />
                        <span class="text-white-dark relative checked:bg-none">Make this my default
                            address</span>
                    </label>
                </div>
                <div class="sm:col-span-2 mt-3">
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
    <form class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 bg-white dark:bg-[#0e1726]">
        <h6 class="text-lg font-bold mb-5">Social</h6>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="flex">
                <div
                    class="bg-[#eee] flex justify-center items-center rounded px-3 font-semibold dark:bg-[#1b2e4b] ltr:mr-2 rtl:ml-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                        </path>
                        <rect x="2" y="9" width="4" height="12"></rect>
                        <circle cx="4" cy="4" r="2"></circle>
                    </svg>
                </div>
                <input type="text" placeholder="jimmy_turner" class="form-input" />
            </div>
            <div class="flex">
                <div
                    class="bg-[#eee] flex justify-center items-center rounded px-3 font-semibold dark:bg-[#1b2e4b] ltr:mr-2 rtl:ml-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path
                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                        </path>
                    </svg>
                </div>
                <input type="text" placeholder="jimmy_turner" class="form-input" />
            </div>
            <div class="flex">
                <div
                    class="bg-[#eee] flex justify-center items-center rounded px-3 font-semibold dark:bg-[#1b2e4b] ltr:mr-2 rtl:ml-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="jimmy_turner" class="form-input" />
            </div>
            <div class="flex">
                <div
                    class="bg-[#eee] flex justify-center items-center rounded px-3 font-semibold dark:bg-[#1b2e4b] ltr:mr-2 rtl:ml-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path
                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                        </path>
                    </svg>
                </div>
                <input type="text" placeholder="jimmy_turner" class="form-input" />
            </div>
        </div>
    </form>
</div>