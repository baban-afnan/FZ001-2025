<!-- Migration Form Modal -->
<div class="modal fade" id="migrationFormModal" tabindex="-1" aria-labelledby="migrationFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content shadow-lg rounded-4 overflow-hidden">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white py-3 sticky-top">
                <div class="d-flex align-items-center w-100">
                    <i class="bi bi-file-earmark-text-fill fs-1 me-3"></i>
                    <div class="flex-grow-1">
                        <h4 class="modal-title fw-bold mb-1" id="migrationFormModalLabel">Agent Registration Form</h4>
                        <p class="mb-0 small opacity-75">Complete all fields to join our agent network</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <!-- Scrollable form content -->
            <div class="modal-body p-0" style="max-height: 70vh; overflow-y: auto;">
                <form action="{{ route('migration-form.store') }}" method="POST" enctype="multipart/form-data" class="p-4 needs-validation" novalidate>
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-start gap-2" role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                            <div>
                                <strong class="d-block mb-1">Please fix the following:</strong>
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Progress indicator -->
                    <div class="progress mb-4" style="height: 8px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="registrationProgressBar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    
                    <!-- Business Information Section -->
                    <section class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-primary mb-0"><i class="bi bi-person-fill me-2"></i>Business Information</h5>
                            <span class="badge bg-primary rounded-pill">1/3</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="business_name">Business Name<span class="text-danger">*</span></label>
                                <input class="form-control" id="business_name" name="business_name" type="text" placeholder="GUDUSISA CONSULT LTD" value="{{ old('business_name') }}" required autocomplete="organization">
                                <div class="invalid-feedback">Please provide your Business Name.</div>
                                @error('business_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="business_address">Business Address<span class="text-danger">*</span></label>
                                <input class="form-control" id="business_address" name="business_address" type="text" placeholder="123 Business Street" value="{{ old('business_address') }}" required autocomplete="street-address">
                                <div class="invalid-feedback">Please provide your Business Address.</div>
                                @error('business_address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 text-primary">
                                <label for="business_email" class="form-label fw-semibold">Business Email <span class="text-danger">*</span></label>
                                <input type="email" id="business_email" name="business_email" class="form-control" placeholder="musa.tanko@gudusisa.com" value="{{ old('business_email') }}" required autocomplete="email">
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                                @error('business_email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Location Information Section -->
                    <section class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-primary mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Location Information</h5>
                            <span class="badge bg-primary rounded-pill">2/3</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="state">State<span class="text-danger">*</span></label>
                                <select class="form-select" id="state" name="state" required>
                                    <option disabled value="" {{ old('state') ? '' : 'selected' }}>Choose State</option>
                                    <option value="Abia" {{ old('state')=='Abia' ? 'selected' : '' }}>Abia</option>
                                    <option value="Adamawa" {{ old('state')=='Adamawa' ? 'selected' : '' }}>Adamawa</option>
                                    <option value="Akwa Ibom" {{ old('state')=='Akwa Ibom' ? 'selected' : '' }}>Akwa Ibom</option>
                                    <option value="Anambra" {{ old('state')=='Anambra' ? 'selected' : '' }}>Anambra</option>
                                    <option value="Bauchi" {{ old('state')=='Bauchi' ? 'selected' : '' }}>Bauchi</option>
                                    <option value="Bayelsa" {{ old('state')=='Bayelsa' ? 'selected' : '' }}>Bayelsa</option>
                                    <option value="Benue" {{ old('state')=='Benue' ? 'selected' : '' }}>Benue</option>
                                    <option value="Borno" {{ old('state')=='Borno' ? 'selected' : '' }}>Borno</option>
                                    <option value="Cross River" {{ old('state')=='Cross River' ? 'selected' : '' }}>Cross River</option>
                                    <option value="Delta" {{ old('state')=='Delta' ? 'selected' : '' }}>Delta</option>
                                    <option value="Ebonyi" {{ old('state')=='Ebonyi' ? 'selected' : '' }}>Ebonyi</option>
                                    <option value="Edo" {{ old('state')=='Edo' ? 'selected' : '' }}>Edo</option>
                                    <option value="Ekiti" {{ old('state')=='Ekiti' ? 'selected' : '' }}>Ekiti</option>
                                    <option value="Enugu" {{ old('state')=='Enugu' ? 'selected' : '' }}>Enugu</option>
                                    <option value="FCT" {{ old('state')=='FCT' ? 'selected' : '' }}>FCT (Abuja)</option>
                                    <option value="Gombe" {{ old('state')=='Gombe' ? 'selected' : '' }}>Gombe</option>
                                    <option value="Imo" {{ old('state')=='Imo' ? 'selected' : '' }}>Imo</option>
                                    <option value="Jigawa" {{ old('state')=='Jigawa' ? 'selected' : '' }}>Jigawa</option>
                                    <option value="Kaduna" {{ old('state')=='Kaduna' ? 'selected' : '' }}>Kaduna</option>
                                    <option value="Kano" {{ old('state')=='Kano' ? 'selected' : '' }}>Kano</option>
                                    <option value="Katsina" {{ old('state')=='Katsina' ? 'selected' : '' }}>Katsina</option>
                                    <option value="Kebbi" {{ old('state')=='Kebbi' ? 'selected' : '' }}>Kebbi</option>
                                    <option value="Kogi" {{ old('state')=='Kogi' ? 'selected' : '' }}>Kogi</option>
                                    <option value="Kwara" {{ old('state')=='Kwara' ? 'selected' : '' }}>Kwara</option>
                                    <option value="Lagos" {{ old('state')=='Lagos' ? 'selected' : '' }}>Lagos</option>
                                    <option value="Nasarawa" {{ old('state')=='Nasarawa' ? 'selected' : '' }}>Nasarawa</option>
                                    <option value="Niger" {{ old('state')=='Niger' ? 'selected' : '' }}>Niger</option>
                                    <option value="Ogun" {{ old('state')=='Ogun' ? 'selected' : '' }}>Ogun</option>
                                    <option value="Ondo" {{ old('state')=='Ondo' ? 'selected' : '' }}>Ondo</option>
                                    <option value="Osun" {{ old('state')=='Osun' ? 'selected' : '' }}>Osun</option>
                                    <option value="Oyo" {{ old('state')=='Oyo' ? 'selected' : '' }}>Oyo</option>
                                    <option value="Plateau" {{ old('state')=='Plateau' ? 'selected' : '' }}>Plateau</option>
                                    <option value="Rivers" {{ old('state')=='Rivers' ? 'selected' : '' }}>Rivers</option>
                                    <option value="Sokoto" {{ old('state')=='Sokoto' ? 'selected' : '' }}>Sokoto</option>
                                    <option value="Taraba" {{ old('state')=='Taraba' ? 'selected' : '' }}>Taraba</option>
                                    <option value="Yobe" {{ old('state')=='Yobe' ? 'selected' : '' }}>Yobe</option>
                                    <option value="Zamfara" {{ old('state')=='Zamfara' ? 'selected' : '' }}>Zamfara</option>
                                </select>
                                <div class="invalid-feedback">Please select your state.</div>
                                @error('state')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="lga">LGA<span class="text-danger">*</span></label>
                                <!-- Using a text input with datalist for better UX and flexibility -->
                                <input class="form-control" id="lga" name="lga" type="text" placeholder="Type or select LGA" value="{{ old('lga') }}" list="lga-options" required>
                                <datalist id="lga-options"></datalist>
                                <div class="form-text">Suggestions will appear based on selected state</div>
                                <div class="invalid-feedback">Please enter your LGA.</div>
                                @error('lga')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="address">Address<span class="text-danger">*</span></label>
                                <input class="form-control" id="address" name="address" type="text" placeholder="NO091 Tudun Wada, Birnin Kebbi" value="{{ old('address') }}" required autocomplete="address-line1">
                                <div class="invalid-feedback">Please provide your address.</div>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="nearest_bustop">Nearest Bus Stop<span class="text-danger">*</span></label>
                                <input class="form-control" id="nearest_bustop" name="nearest_bustop" type="text" placeholder="UZOGU VILLAGE" value="{{ old('nearest_bustop') }}" required>
                                <div class="invalid-feedback">Please provide nearest bus stop.</div>
                                @error('nearest_bustop')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Document Upload Section -->
                    <section class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-primary mb-0"><i class="bi bi-file-earmark-arrow-up-fill me-2"></i>Document Uploads</h5>
                            <span class="badge bg-primary rounded-pill">3/3</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="office_image">Office Image</label>
                                <input class="form-control" id="office_image" name="office_image" type="file" accept="image/*">
                                <div class="form-text">Upload a clear image of your office (JPG/PNG, max 5MB).</div>
                                @error('office_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="nepa_bill">NEPA Bill</label>
                                <input class="form-control" id="nepa_bill" name="nepa_bill" type="file" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text">Upload your NEPA bill (PDF/JPG/PNG, max 10MB).</div>
                                @error('nepa_bill')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 text-primary">
                                <label class="form-label" for="cac_upload">CAC Document</label>
                                <input class="form-control" id="cac_upload" name="cac_upload" type="file" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text">Upload your CAC document (PDF/JPG/PNG, max 10MB).</div>
                                @error('cac_upload')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Form Submission -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-3" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle-fill me-2"></i>Cancel
                        </button>
                        <button class="btn btn-primary px-4 py-2 rounded-3" type="submit">
                            <i class="bi bi-send-fill me-2"></i>Submit Registration
                        </button>
                    </div>
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-gradient-primary text-white border-0 rounded-top">
        <h3 class="mb-0"><i class="bi bi-shield-check me-2"></i> Agent Activation Rules</h3>
    </div>
    <div class="card-body">
        <p class="text-muted">Before your account can be activated as an <strong>Agent</strong>, please ensure you meet the following requirements:</p>
        
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <i class="bi bi-wallet2 text-primary me-2"></i>
                Must have at least <strong>₦20,000</strong> or above in your wallet.
            </li>
            <li class="list-group-item">
                <i class="bi bi-people-fill text-success me-2"></i>
                To be approved as a <strong>BVN Agent</strong>, you must have at least <strong>20 active agents</strong>.
            </li>
            <li class="list-group-item">
                <i class="bi bi-file-earmark-check-fill text-info me-2"></i>
                Must provide <strong>valid documents</strong>.
            </li>
            <li class="list-group-item">
                <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                Must provide a <strong>valid address</strong>.
            </li>
            <li class="list-group-item">
                <i class="bi bi-hourglass-split text-danger me-2"></i>
                Approval may take up to <strong>7 working days</strong>.
            </li>
        </ul>
    </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Inline helper script for progress + validation + LGA suggestions -->
<script>
    (function() {
        const form = document.querySelector('#migrationFormModal form');
        if (!form) return;

        // Bootstrap validation
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);

        // Progress tracking based on required fields
        const progressBar = document.getElementById('registrationProgressBar');
        const requiredSelectors = [
            '#business_name', '#business_address', '#business_email',
            '#state', '#lga', '#address', '#nearest_bustop'
        ];
        const requiredFields = requiredSelectors
            .map(sel => form.querySelector(sel))
            .filter(Boolean);

        function updateProgress() {
            const filled = requiredFields.reduce((acc, el) => {
                if (!el) return acc;
                if (el.type === 'select-one') {
                    return acc + (el.value && el.value.trim() !== '' ? 1 : 0);
                }
                return acc + (el.value && el.value.trim() !== '' ? 1 : 0);
            }, 0);
            const total = requiredFields.length || 1;
            const percent = Math.round((filled / total) * 100);
            if (progressBar) {
                progressBar.style.width = percent + '%';
                progressBar.setAttribute('aria-valuenow', String(percent));
            }
        }
        requiredFields.forEach(el => {
            ['input', 'change'].forEach(evt => el.addEventListener(evt, updateProgress));
        });
        updateProgress();

        // LGA suggestions by state (datalist)
        const stateToLgas = {
           "Abia": ["Aba North", "Aba South", "Arochukwu", "Bende", "Ikwuano", "Isiala Ngwa North", "Isiala Ngwa South", "Isuikwuato", "Obi Ngwa", "Ohafia", "Osisioma", "Ugwunagbo", "Ukwa East", "Ukwa West", "Umuahia North", "Umuahia South", "Umu Nneochi"],
    "Adamawa": ["Demsa", "Fufore", "Ganye", "Girei", "Gombi", "Guyuk", "Hong", "Jada", "Lamurde", "Madagali", "Maiha", "Mayo Belwa", "Michika", "Mubi North", "Mubi South", "Numan", "Shelleng", "Song", "Toungo", "Yola North", "Yola South"],
    "Akwa Ibom": ["Abak", "Eastern Obolo", "Eket", "Esit Eket", "Essien Udim", "Etim Ekpo", "Etinan", "Ibeno", "Ibesikpo Asutan", "Ibiono Ibom", "Ika", "Ikono", "Ikot Abasi", "Ikot Ekpene", "Ini", "Itu", "Mbo", "Mkpat Enin", "Nsit Atai", "Nsit Ibom", "Nsit Ubium", "Obot Akara", "Okobo", "Onna", "Oron", "Oruk Anam", "Udung Uko", "Ukanafun", "Uruan", "Urue-Offong/Oruko", "Uyo"],
    "Anambra": ["Aguata", "Anambra East", "Anambra West", "Anaocha", "Awka North", "Awka South", "Ayamelum", "Dunukofia", "Ekwusigo", "Idemili North", "Idemili South", "Ihiala", "Njikoka", "Nnewi North", "Nnewi South", "Ogbaru", "Onitsha North", "Onitsha South", "Orumba North", "Orumba South", "Oyi"],
    "Bauchi": ["Alkaleri", "Bauchi", "Bogoro", "Damban", "Darazo", "Dass", "Gamawa", "Ganjuwa", "Giade", "Itas/Gadau", "Jama'are", "Katagum", "Kirfi", "Misau", "Ningi", "Shira", "Tafawa Balewa", "Toro", "Warji", "Zaki"],
    "Bayelsa": ["Brass", "Ekeremor", "Kolokuma/Opokuma", "Nembe", "Ogbia", "Sagbama", "Southern Ijaw", "Yenagoa"],
    "Benue": ["Ado", "Agatu", "Apa", "Buruku", "Gboko", "Guma", "Gwer East", "Gwer West", "Katsina-Ala", "Konshisha", "Kwande", "Logo", "Makurdi", "Obi", "Ogbadibo", "Ohimini", "Oju", "Okpokwu", "Otukpo", "Tarka", "Ukum", "Ushongo", "Vandeikya"],
    "Borno": ["Abadam", "Askira/Uba", "Bama", "Bayo", "Biu", "Chibok", "Damboa", "Dikwa", "Gubio", "Guzamala", "Gwoza", "Hawul", "Jere", "Kaga", "Kala/Balge", "Konduga", "Kukawa", "Kwaya Kusar", "Mafa", "Magumeri", "Maiduguri", "Marte", "Mobbar", "Monguno", "Ngala", "Nganzai", "Shani"],
    "Cross River": ["Abi", "Akamkpa", "Akpabuyo", "Bakassi", "Bekwarra", "Biase", "Boki", "Calabar Municipal", "Calabar South", "Etung", "Ikom", "Obanliku", "Obubra", "Obudu", "Odukpani", "Ogoja", "Yakurr", "Yala"],
    "Delta": ["Aniocha North", "Aniocha South", "Bomadi", "Burutu", "Ethiope East", "Ethiope West", "Ika North East", "Ika South", "Isoko North", "Isoko South", "Ndokwa East", "Ndokwa West", "Okpe", "Oshimili North", "Oshimili South", "Patani", "Sapele", "Udu", "Ughelli North", "Ughelli South", "Ukwuani", "Uvwie", "Warri North", "Warri South", "Warri South West"],
    "Ebonyi": ["Abakaliki", "Afikpo North", "Afikpo South", "Ebonyi", "Ezza North", "Ezza South", "Ikwo", "Ishielu", "Ivo", "Izzi", "Ohaozara", "Ohaukwu", "Onicha"],
    "Edo": ["Akoko-Edo", "Egor", "Esan Central", "Esan North-East", "Esan South-East", "Esan West", "Etsako Central", "Etsako East", "Etsako West", "Igueben", "Ikpoba-Okha", "Oredo", "Orhionmwon", "Ovia North-East", "Ovia South-West", "Owan East", "Owan West", "Uhunmwonde"],
    "Ekiti": ["Ado Ekiti", "Efon", "Ekiti East", "Ekiti South-West", "Ekiti West", "Emure", "Gbonyin", "Ido Osi", "Ijero", "Ikere", "Ikole", "Ilejemeje", "Irepodun/Ifelodun", "Ise/Orun", "Moba", "Oye"],
    "Enugu": ["Aninri", "Awgu", "Enugu East", "Enugu North", "Enugu South", "Ezeagu", "Igbo Etiti", "Igbo Eze North", "Igbo Eze South", "Isi Uzo", "Nkanu East", "Nkanu West", "Nsukka", "Oji River", "Udenu", "Udi", "Uzo Uwani"],
    "FCT": ["Abaji", "Bwari", "Gwagwalada", "Kuje", "Kwali", "Municipal Area Council"],
    "Gombe": ["Akko", "Balanga", "Billiri", "Dukku", "Funakaye", "Gombe", "Kaltungo", "Kwami", "Nafada", "Shongom", "Yamaltu/Deba"],
    "Imo": ["Aboh Mbaise", "Ahiazu Mbaise", "Ehime Mbano", "Ezinihitte", "Ideato North", "Ideato South", "Ihitte/Uboma", "Ikeduru", "Isiala Mbano", "Isu", "Mbaitoli", "Ngor Okpala", "Njaba", "Nkwerre", "Nwangele", "Obowo", "Oguta", "Ohaji/Egbema", "Okigwe", "Orlu", "Orsu", "Oru East", "Oru West", "Owerri Municipal", "Owerri North", "Owerri West"],
    "Jigawa": ["Auyo", "Babura", "Biriniwa", "Birnin Kudu", "Buji", "Dutse", "Gagarawa", "Garki", "Gumel", "Guri", "Gwaram", "Gwiwa", "Hadejia", "Jahun", "Kafin Hausa", "Kaugama", "Kazaure", "Kiri Kasama", "Kiyawa", "Maigatari", "Malam Madori", "Miga", "Ringim", "Roni", "Sule Tankarkar", "Taura", "Yankwashi"],
    "Kaduna": ["Birnin Gwari", "Chikun", "Giwa", "Igabi", "Ikara", "Jaba", "Jema'a", "Kachia", "Kaduna North", "Kaduna South", "Kagarko", "Kajuru", "Kaura", "Kauru", "Kubau", "Kudan", "Lere", "Makarfi", "Sabon Gari", "Sanga", "Soba", "Zangon Kataf", "Zaria"],
    "Kano": ["Ajingi", "Albasu", "Bagwai", "Bebeji", "Bichi", "Bunkure", "Dala", "Dambatta", "Dawakin Kudu", "Dawakin Tofa", "Doguwa", "Fagge", "Gabasawa", "Garko", "Garun Mallam", "Gaya", "Gezawa", "Gwale", "Gwarzo", "Kabo", "Kano Municipal", "Karaye", "Kibiya", "Kiru", "Kumbotso", "Kunchi", "Kura", "Madobi", "Makoda", "Minjibir", "Nasarawa", "Rano", "Rimin Gado", "Rogo", "Shanono", "Sumaila", "Takai", "Tarauni", "Tofa", "Tsanyawa", "Tudun Wada", "Ungogo", "Warawa", "Wudil"],
    "Katsina": ["Bakori", "Batagarawa", "Batsari", "Baure", "Bindawa", "Charanchi", "Dandume", "Danja", "Dan Musa", "Daura", "Dutsi", "Dutsin Ma", "Faskari", "Funtua", "Ingawa", "Jibia", "Kafur", "Kaita", "Kankara", "Kankia", "Katsina", "Kurfi", "Kusada", "Mai'Adua", "Malumfashi", "Mani", "Mashi", "Matazu", "Musawa", "Rimi", "Sabuwa", "Safana", "Sandamu", "Zango"],
    "Kebbi": ["Aleiro", "Arewa Dandi", "Argungu", "Augie", "Bagudo", "Birnin Kebbi", "Bunza", "Dandi", "Fakai", "Gwandu", "Jega", "Kalgo", "Koko/Besse", "Maiyama", "Ngaski", "Sakaba", "Shanga", "Suru", "Wasagu/Danko", "Yauri", "Zuru"],
    "Kogi": ["Adavi", "Ajaokuta", "Ankpa", "Bassa", "Dekina", "Ibaji", "Idah", "Igalamela Odolu", "Ijumu", "Kabba/Bunu", "Kogi", "Lokoja", "Mopa-Muro", "Ofu", "Ogori/Magongo", "Okehi", "Okene", "Olamaboro", "Omala", "Yagba East", "Yagba West"],
    "Kwara": ["Asa", "Baruten", "Edu", "Ekiti", "Ifelodun", "Ilorin East", "Ilorin South", "Ilorin West", "Irepodun", "Isin", "Kaiama", "Moro", "Offa", "Oke Ero", "Oyun", "Pategi"],
    "Lagos": ["Agege", "Ajeromi-Ifelodun", "Alimosho", "Amuwo-Odofin", "Apapa", "Badagry", "Epe", "Eti Osa", "Ibeju-Lekki", "Ifako-Ijaiye", "Ikeja", "Ikorodu", "Kosofe", "Lagos Island", "Lagos Mainland", "Mushin", "Ojo", "Oshodi-Isolo", "Shomolu", "Surulere"],
    "Nasarawa": ["Akwanga", "Awe", "Doma", "Karu", "Keana", "Keffi", "Kokona", "Lafia", "Nasarawa", "Nasarawa Egon", "Obi", "Toto", "Wamba"],
    "Niger": ["Agaie", "Agwara", "Bida", "Borgu", "Bosso", "Chanchaga", "Edati", "Gbako", "Gurara", "Katcha", "Kontagora", "Lapai", "Lavun", "Magama", "Mariga", "Mashegu", "Mokwa", "Munya", "Paikoro", "Rafi", "Rijau", "Shiroro", "Suleja", "Tafa", "Wushishi"],
    "Ogun": ["Abeokuta North", "Abeokuta South", "Ado-Odo/Ota", "Egbado North", "Egbado South", "Ewekoro", "Ifo", "Ijebu East", "Ijebu North", "Ijebu North East", "Ijebu Ode", "Ikenne", "Imeko Afon", "Ipokia", "Obafemi Owode", "Odeda", "Odogbolu", "Ogun Waterside", "Remo North", "Shagamu"],
    "Ondo": ["Akoko North-East", "Akoko North-West", "Akoko South-East", "Akoko South-West", "Akure North", "Akure South", "Ese Odo", "Idanre", "Ifedore", "Ilaje", "Ile Oluji/Okeigbo", "Irele", "Odigbo", "Okitipupa", "Ondo East", "Ondo West", "Ose", "Owo"],
    "Osun": ["Aiyedaade", "Aiyedire", "Atakumosa East", "Atakumosa West", "Boluwaduro", "Boripe", "Ede North", "Ede South", "Egbedore", "Ejigbo", "Ife Central", "Ife East", "Ife North", "Ife South", "Ifedayo", "Ifelodun", "Ila", "Ilesa East", "Ilesa West", "Irepodun", "Irewole", "Isokan", "Iwo", "Obokun", "Odo Otin", "Ola Oluwa", "Olorunda", "Oriade", "Orolu", "Osogbo"],
    "Oyo": ["Afijio", "Akinyele", "Atiba", "Atisbo", "Egbeda", "Ibadan North", "Ibadan North-East", "Ibadan North-West", "Ibadan South-East", "Ibadan South-West", "Ibarapa Central", "Ibarapa East", "Ibarapa North", "Ido", "Irepo", "Iseyin", "Itesiwaju", "Iwajowa", "Kajola", "Lagelu", "Ogbomosho North", "Ogbomosho South", "Ogo Oluwa", "Olorunsogo", "Oluyole", "Ona Ara", "Orelope", "Ori Ire", "Oyo East", "Oyo West", "Saki East", "Saki West", "Surulere"],
    "Plateau": ["Barkin Ladi", "Bassa", "Bokkos", "Jos East", "Jos North", "Jos South", "Kanam", "Kanke", "Langtang North", "Langtang South", "Mangu", "Mikang", "Pankshin", "Qua'an Pan", "Riyom", "Shendam", "Wase"],
    "Rivers": ["Abua/Odual", "Ahoada East", "Ahoada West", "Akuku-Toru", "Andoni", "Asari-Toru", "Bonny", "Degema", "Eleme", "Emohua", "Etche", "Gokana", "Ikwerre", "Khana", "Obio/Akpor", "Ogba/Egbema/Ndoni", "Ogu/Bolo", "Okrika", "Omuma", "Opobo/Nkoro", "Oyigbo", "Port Harcourt", "Tai"],
    "Sokoto": ["Binji", "Bodinga", "Dange Shuni", "Gada", "Goronyo", "Gudu", "Gwadabawa", "Illela", "Isa", "Kebbe", "Kware", "Rabah", "Sabon Birni", "Shagari", "Silame", "Sokoto North", "Sokoto South", "Tambuwal", "Tangaza", "Tureta", "Wamako", "Wurno", "Yabo"],
    "Taraba": ["Ardo Kola", "Bali", "Donga", "Gashaka", "Gassol", "Ibi", "Jalingo", "Karim Lamido", "Kumi", "Lau", "Sardauna", "Takum", "Ussa", "Wukari", "Yorro", "Zing"],
    "Yobe": ["Bade", "Bursari", "Damaturu", "Fika", "Fune", "Geidam", "Gujba", "Gulani", "Jakusko", "Karasuwa", "Machina", "Nangere", "Nguru", "Potiskum", "Tarmuwa", "Yunusari", "Yusufari"],
    "Zamfara": ["Anka", "Bakura", "Birnin Magaji/Kiyaw", "Bukkuyum", "Bungudu", "Gummi", "Gusau", "Kaura Namoda", "Maradun", "Maru", "Shinkafi", "Talata Mafara", "Chafe", "Zurmi"]
    
      };
        const stateEl = form.querySelector('#state');
        const lgaInput = form.querySelector('#lga');
        const lgaDatalist = form.querySelector('#lga-options');

        function refreshLgaOptions() {
            if (!stateEl || !lgaDatalist) return;
            const st = stateEl.value || '';
            const options = stateToLgas[st] || [];
            lgaDatalist.innerHTML = '';
            options.forEach(lga => {
                const opt = document.createElement('option');
                opt.value = lga;
                lgaDatalist.appendChild(opt);
            });
        }
        if (stateEl) {
            stateEl.addEventListener('change', () => {
                refreshLgaOptions();
                // Clear previous value if state changed
                if (lgaInput) lgaInput.value = '';
                updateProgress();
            });
            // Initialize on load (for old state)
            refreshLgaOptions();
        }
    })();
</script>
