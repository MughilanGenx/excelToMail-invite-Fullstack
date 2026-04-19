<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Data Extractor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-bg: #f8fafc;
            --surface-bg: #ffffff;
            --text-main: #0f172a;
            --text-secondary: #475569;
            --accent-color: #3b82f6;
            --accent-hover: #2563eb;
            --border-color: #e2e8f0;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --success-border: #bbf7d0;
            --error-bg: #fee2e2;
            --error-text: #991b1b;
            --save-color: #8b5cf6;
            --save-hover: #7c3aed;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-main);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 2rem;
        }

        .container { max-width: 1200px; margin: 0 auto; width: 100%; }

        header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInDown 0.6s ease-out;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        p.subtitle { font-size: 1.125rem; color: var(--text-secondary); }

        .card {
            background-color: var(--surface-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
            transition: box-shadow 0.3s ease;
            animation: fadeInUp 0.7s ease-out;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.05), 0 4px 6px -4px rgb(0 0 0 / 0.05);
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .alert-error  { background-color: var(--error-bg);   color: var(--error-text);   border: 1px solid #fecaca; }
        .alert-success{ background-color: var(--success-bg); color: var(--success-text); border: 1px solid var(--success-border); }

        /* ---- Upload area ---- */
        .upload-area {
            border: 2px dashed var(--accent-color);
            border-radius: 12px;
            padding: 3rem;
            text-align: center;
            background-color: #eff6ff;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        .upload-area:hover { background-color: #dbeafe; border-color: var(--accent-hover); }
        .upload-area input[type="file"] {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0; cursor: pointer;
        }
        .upload-icon  { font-size: 3rem; margin-bottom: 1rem; color: var(--accent-color); display: inline-block; }
        .upload-text  { font-size: 1.25rem; font-weight: 600; color: var(--accent-color); display: block; margin-bottom: 0.5rem; }
        .upload-hint  { font-size: 0.875rem; color: var(--text-secondary); }
        #file-name-display { margin-top: 1rem; font-weight: 500; color: var(--text-main); display: none; }

        .action-container { margin-top: 2rem; text-align: center; }

        /* ---- Buttons ---- */
        .btn-primary {
            background-color: var(--accent-color);
            color: white; padding: 0.75rem 2rem;
            border-radius: 8px; font-weight: 600;
            font-size: 1rem; border: none; cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            box-shadow: 0 4px 6px -1px rgb(59 130 246 / 0.3);
        }
        .btn-primary:hover  { background-color: var(--accent-hover); }
        .btn-primary:active { transform: scale(0.98); }

        .btn-save {
            background-color: var(--save-color);
            color: white; padding: 0.65rem 1.5rem;
            border-radius: 8px; font-weight: 600;
            font-size: 0.9rem; border: none; cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            box-shadow: 0 4px 6px -1px rgb(139 92 246 / 0.3);
            white-space: nowrap;
        }
        .btn-save:hover  { background-color: var(--save-hover); }
        .btn-save:active { transform: scale(0.98); }

        .btn-link {
            background: none; border: none;
            color: var(--accent-color); font-size: 0.875rem;
            font-weight: 500; cursor: pointer; text-decoration: underline;
            padding: 0;
        }

        /* ---- Save Column Panel ---- */
        .save-panel {
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
            border: 1px solid #c4b5fd;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            animation: fadeIn 0.4s ease-out;
        }

        .save-panel h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--save-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .save-row {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .save-field {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            flex: 1;
            min-width: 180px;
        }

        .save-field label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .save-field select,
        .save-field input[type="text"] {
            padding: 0.6rem 0.9rem;
            border-radius: 8px;
            border: 1px solid #c4b5fd;
            background-color: white;
            color: var(--text-main);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .save-field select:focus,
        .save-field input[type="text"]:focus {
            border-color: var(--save-color);
            box-shadow: 0 0 0 3px rgb(139 92 246 / 0.15);
        }

        .save-preview {
            margin-top: 1rem;
            font-size: 0.8rem;
            color: var(--text-secondary);
            background: white;
            border: 1px solid #e9d5ff;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            word-break: break-all;
            font-family: 'Courier New', monospace;
        }

        .save-preview strong { color: var(--save-color); }

        /* ---- Data Table ---- */
        .data-section {
            animation: fadeIn 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }

        .data-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .data-header h2 { font-size: 1.5rem; font-weight: 600; }

        .header-controls { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }

        .badge {
            background-color: var(--success-bg);
            color: var(--success-text);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .form-select {
            padding: 0.375rem 2rem 0.375rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-bg);
            color: var(--text-main);
            font-size: 0.875rem;
            font-weight: 500;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: var(--surface-bg);
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }

        th, td { padding: 1rem; border-bottom: 1px solid var(--border-color); }

        th {
            background-color: #f8fafc;
            font-weight: 600;
            color: var(--text-main);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            position: sticky;
            top: 0;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.2s;
        }

        th:hover { background-color: #ede9fe; color: var(--save-color); }

        th.selected-col {
            background-color: #ede9fe;
            color: var(--save-color);
            border-bottom: 2px solid var(--save-color);
        }

        td.selected-col { background-color: #faf5ff; }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f1f5f9; }

        .empty-state { text-align: center; padding: 4rem 2rem; color: var(--text-secondary); }

        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .page-btn {
            background-color: var(--surface-bg);
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .page-btn:hover:not(:disabled) { background-color: #f1f5f9; border-color: var(--accent-color); }
        .page-btn:disabled { opacity: 0.5; cursor: not-allowed; background-color: #f8fafc; }

        .page-info { font-size: 0.875rem; font-weight: 500; color: var(--text-secondary); }

        .nav-link {
            display: inline-flex; align-items: center; gap: 0.4rem;
            color: var(--accent-color); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; transition: color 0.2s;
        }
        .nav-link:hover { color: var(--accent-hover); }

        /* Animations */
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp   { from { opacity: 0; transform: translateY(20px);  } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn     { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Excel Data Extractor</h1>
            <p class="subtitle">Upload, preview, select a column and save it to database</p>
        </header>

        {{-- Flash messages --}}
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @error('excel_file')
            <div class="alert alert-error">{{ $message }}</div>
        @enderror

        {{-- Upload Form --}}
        <section class="card">
            <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="upload-area" id="drop-zone">
                    <input type="file" name="excel_file" id="excel_file" accept=".xlsx, .xls, .csv" required>
                    <div class="upload-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="18" x2="12" y2="12"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg>
                    </div>
                    <span class="upload-text">Click to browse or drag and drop</span>
                    <span class="upload-hint">Supported: .xlsx, .xls, .csv (Max 10MB)</span>
                    <div id="file-name-display"></div>
                </div>
                <div class="action-container">
                    <button type="submit" class="btn-primary">Extract Data</button>
                    &nbsp;&nbsp;
                    <a href="{{ route('excel.saved') }}" class="nav-link">📋 View Saved Records →</a>
                </div>
            </form>
        </section>

        {{-- Data Table + Save Column Panel --}}
        @if(isset($headers) && isset($rows))
            <section class="card data-section">
                <div class="data-header">
                    <h2>Extracted Data
                        <span style="font-size:0.85rem;font-weight:400;color:var(--text-secondary);margin-left:0.5rem;">
                            — click a column header to select it
                        </span>
                    </h2>
                    <div class="header-controls">
                        <select id="perPage" class="form-select">
                            <option value="10">10 per page</option>
                            <option value="20" selected>20 per page</option>
                            <option value="30">30 per page</option>
                            <option value="all">All</option>
                        </select>
                        <span class="badge" id="totalRowsBadge">{{ count($rows) }} Rows Found</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="dataTable">
                        <thead>
                            <tr>
                                @foreach($headers as $index => $header)
                                    <th data-col-index="{{ $index }}" data-col-name="{{ $header ?: 'Column ' . ($index + 1) }}"
                                        onclick="selectColumn({{ $index }}, '{{ addslashes($header ?: 'Column ' . ($index + 1)) }}')"
                                        title="Click to select this column">
                                        {{ $header ?: 'Column ' . ($index + 1) }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $row)
                                <tr>
                                    @foreach($headers as $index => $header)
                                        <td data-col-index="{{ $index }}">
                                            {{ isset($row[$index]) && is_scalar($row[$index]) ? $row[$index] : '' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($headers) }}" class="empty-state">No data found below the headers.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container" id="paginationControls"></div>

                {{-- Save Column Panel (hidden until column selected) --}}
                <div id="savePanel" class="save-panel" style="display:none;">
                    <h3>
                        💾 Save Selected Column to Database
                    </h3>

                    <form action="{{ route('excel.save') }}" method="POST" id="saveForm">
                        @csrf

                        {{-- Hidden: the original Excel column header --}}
                        <input type="hidden" name="excel_column" id="excelColumnInput">

                        {{-- Hidden: all values from this column (submitted as array) --}}
                        <div id="valuesContainer"></div>

                        <div class="save-row">
                            <div class="save-field">
                                <label>Selected Column (Excel Header)</label>
                                <input type="text" id="selectedColDisplay" readonly
                                       style="background:#f5f3ff;color:var(--save-color);font-weight:600;">
                            </div>

                            <div class="save-field">
                                <label for="columnNameInput">Custom Field Name (stored as key)</label>
                                <input type="text" name="column_name" id="columnNameInput"
                                       placeholder="e.g. email_list, phone_numbers…" required>
                            </div>

                            <button type="submit" class="btn-save">💾 Save to DB</button>
                        </div>

                        <div class="save-preview" id="savePreview">
                            Select a column header above to preview the values that will be stored.
                        </div>
                    </form>
                </div>
            </section>
        @endif
    </div>

    {{-- Pass PHP rows data to JS --}}
    @if(isset($headers) && isset($rows))
    <script>
        const phpHeaders = @json($headers);
        const phpRows    = @json($rows);
    </script>
    @endif

    <script>
        /* ===================== File Upload UI ===================== */
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput      = document.getElementById('excel_file');
            const fileNameDisplay= document.getElementById('file-name-display');
            const dropZone       = document.getElementById('drop-zone');

            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        fileNameDisplay.textContent = 'Selected: ' + this.files[0].name;
                        fileNameDisplay.style.display = 'block';
                        dropZone.style.borderColor = 'var(--accent-hover)';
                        dropZone.style.backgroundColor = '#dbeafe';
                    }
                });

                ['dragenter','dragover','dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); }));
                ['dragenter','dragover'].forEach(e => dropZone.addEventListener(e, () => { dropZone.style.borderColor='var(--accent-hover)'; dropZone.style.backgroundColor='#dbeafe'; }));
                ['dragleave','drop'].forEach(e => dropZone.addEventListener(e, () => { if (!fileInput.files.length) { dropZone.style.borderColor='var(--accent-color)'; dropZone.style.backgroundColor='#eff6ff'; } }));

                dropZone.addEventListener('drop', function (e) {
                    const files = e.dataTransfer.files;
                    if (files && files.length) {
                        fileInput.files = files;
                        fileInput.dispatchEvent(new Event('change'));
                    }
                });
            }

            /* ===================== Pagination ===================== */
            const tableBody = document.querySelector('tbody');
            if (tableBody) {
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                if (!(rows.length === 1 && rows[0].querySelector('.empty-state'))) {
                    const perPageSelect     = document.getElementById('perPage');
                    const paginationControls= document.getElementById('paginationControls');
                    let currentPage  = 1;
                    let rowsPerPage  = 20;

                    function renderTable() {
                        const total      = rows.length;
                        const totalPages = rowsPerPage === 'all' ? 1 : Math.ceil(total / rowsPerPage);
                        if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
                        if (currentPage < 1) currentPage = 1;

                        const start = rowsPerPage === 'all' ? 0 : (currentPage - 1) * rowsPerPage;
                        const end   = rowsPerPage === 'all' ? total : start + rowsPerPage;

                        rows.forEach((row, i) => row.style.display = (i >= start && i < end) ? '' : 'none');
                        renderControls(totalPages);
                    }

                    function renderControls(totalPages) {
                        if (!paginationControls) return;
                        paginationControls.innerHTML = '';
                        if (totalPages <= 1) { paginationControls.style.display = 'none'; return; }
                        paginationControls.style.display = 'flex';

                        const prev = document.createElement('button');
                        prev.textContent = 'Previous'; prev.className = 'page-btn';
                        prev.disabled = currentPage === 1; prev.type = 'button';
                        prev.onclick = () => { currentPage--; renderTable(); };
                        paginationControls.appendChild(prev);

                        const info = document.createElement('span');
                        info.textContent = `Page ${currentPage} of ${totalPages}`;
                        info.className = 'page-info';
                        paginationControls.appendChild(info);

                        const next = document.createElement('button');
                        next.textContent = 'Next'; next.className = 'page-btn';
                        next.disabled = currentPage === totalPages; next.type = 'button';
                        next.onclick = () => { currentPage++; renderTable(); };
                        paginationControls.appendChild(next);
                    }

                    if (perPageSelect) {
                        perPageSelect.addEventListener('change', e => {
                            rowsPerPage = e.target.value === 'all' ? 'all' : parseInt(e.target.value, 10);
                            currentPage = 1;
                            renderTable();
                        });
                        renderTable();
                    }
                }
            }
        });

        /* ===================== Column Selection ===================== */
        let selectedColIndex = null;

        function selectColumn(colIndex, colName) {
            selectedColIndex = colIndex;

            /* Highlight header */
            document.querySelectorAll('#dataTable th').forEach(th => th.classList.remove('selected-col'));
            document.querySelectorAll('#dataTable td').forEach(td => td.classList.remove('selected-col'));

            const selTh = document.querySelector(`#dataTable th[data-col-index="${colIndex}"]`);
            if (selTh) selTh.classList.add('selected-col');
            document.querySelectorAll(`#dataTable td[data-col-index="${colIndex}"]`).forEach(td => td.classList.add('selected-col'));

            /* Collect all values from this column (all rows in phpRows, not just visible) */
            const values = (typeof phpRows !== 'undefined' ? phpRows : []).map(row => row[colIndex] ?? '');

            /* Build hidden input fields for values[] */
            const container = document.getElementById('valuesContainer');
            container.innerHTML = '';
            values.forEach(val => {
                const inp = document.createElement('input');
                inp.type  = 'hidden';
                inp.name  = 'values[]';
                inp.value = val ?? '';
                container.appendChild(inp);
            });

            /* Update display fields */
            document.getElementById('excelColumnInput').value  = colName;
            document.getElementById('selectedColDisplay').value = colName;

            /* Preview */
            const nonEmpty = values.filter(v => v !== null && v !== '');
            const preview  = nonEmpty.join(',');
            document.getElementById('savePreview').innerHTML =
                `<strong>Preview (${nonEmpty.length} values):</strong><br>[${preview}]`;

            /* Show panel */
            const panel = document.getElementById('savePanel');
            panel.style.display = 'block';
            panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            /* Auto-fill name if user hasn't typed yet */
            const nameInput = document.getElementById('columnNameInput');
            if (!nameInput.value) nameInput.value = colName.toLowerCase().replace(/\s+/g, '_');
        }
    </script>
</body>
</html>
