<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Data Extractor</title>
    <!-- Fonts -->
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
            --error-bg: #fee2e2;
            --error-text: #991b1b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

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

        p.subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
        }

        .card {
            background-color: var(--surface-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInUp 0.7s ease-out;
        }
        
        .card:hover {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.05), 0 4px 6px -4px rgb(0 0 0 / 0.05);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #fecaca;
        }

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

        .upload-area:hover {
            background-color: #dbeafe;
            border-color: var(--accent-hover);
        }

        .upload-area input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
            display: inline-block;
        }

        .upload-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--accent-color);
            display: block;
            margin-bottom: 0.5rem;
        }

        .upload-hint {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .action-container {
            margin-top: 2rem;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            box-shadow: 0 4px 6px -1px rgb(59 130 246 / 0.3);
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .data-section {
            animation: fadeIn 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }

        .data-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .data-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .badge {
            background-color: var(--success-bg);
            color: var(--success-text);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: var(--surface-bg);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: #f8fafc;
            font-weight: 600;
            color: var(--text-main);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            position: sticky;
            top: 0;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f1f5f9;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
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

        .form-select:hover {
            border-color: var(--accent-hover);
        }

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

        .page-btn:hover:not(:disabled) {
            background-color: #f1f5f9;
            border-color: var(--accent-color);
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #f8fafc;
        }

        .page-info {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        #file-name-display {
            margin-top: 1rem;
            font-weight: 500;
            color: var(--text-main);
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Excel Data Extractor</h1>
            <p class="subtitle">Upload your Excel file automatically to visualize its contents</p>
        </header>

        <section class="card">
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @error('excel_file')
                <div class="alert alert-error">
                    {{ $message }}
                </div>
            @enderror

            <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="upload-area" id="drop-zone">
                    <input type="file" name="excel_file" id="excel_file" accept=".xlsx, .xls, .csv" required>
                    <div class="upload-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="18" x2="12" y2="12"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg>
                    </div>
                    <span class="upload-text">Click to browse or drag and drop</span>
                    <span class="upload-hint">Supported formats: .xlsx, .xls, .csv (Max 10MB)</span>
                    <div id="file-name-display"></div>
                </div>

                <div class="action-container">
                    <button type="submit" class="btn-primary">
                        Extract Data
                    </button>
                </div>
            </form>
        </section>

        @if(isset($headers) && isset($rows))
            <section class="card data-section">
                <div class="data-header">
                    <h2>Extracted Data</h2>
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
                    <table>
                        <thead>
                            <tr>
                                @foreach($headers as $index => $header)
                                    <th>{{ $header ?: 'Column ' . ($index + 1) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $row)
                                <tr>
                                    @foreach($headers as $index => $header)
                                        <td>{{ isset($row[$index]) && is_scalar($row[$index]) ? $row[$index] : '' }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($headers) }}" class="empty-state">
                                        No data found below the headers.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-container" id="paginationControls"></div>
            </section>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('excel_file');
            const fileNameDisplay = document.getElementById('file-name-display');
            const dropZone = document.getElementById('drop-zone');

            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileNameDisplay.textContent = 'Selected File: ' + fileName;
                    fileNameDisplay.style.display = 'block';
                    dropZone.style.borderColor = 'var(--accent-hover)';
                    dropZone.style.backgroundColor = '#dbeafe';
                }
            });

            // Handle drag and drop visuals
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.style.borderColor = 'var(--accent-hover)';
                dropZone.style.backgroundColor = '#dbeafe';
            }

            function unhighlight(e) {
                if (!fileInput.files.length) {
                    dropZone.style.borderColor = 'var(--accent-color)';
                    dropZone.style.backgroundColor = '#eff6ff';
                }
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files && files.length) {
                    fileInput.files = files;
                    
                    // Manually trigger the change event to update the display
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            }

            // Pagination Script
            const tableBody = document.querySelector('tbody');
            if (tableBody) {
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                // avoid paginating the empty state row
                if (!(rows.length === 1 && rows[0].querySelector('.empty-state'))) {
                    const perPageSelect = document.getElementById('perPage');
                    const paginationControls = document.getElementById('paginationControls');
                    
                    let currentPage = 1;
                    let rowsPerPage = 20;

                    function renderTable() {
                        const totalRows = rows.length;
                        const totalPages = rowsPerPage === 'all' ? 1 : Math.ceil(totalRows / rowsPerPage);
                        
                        if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
                        if (currentPage < 1) currentPage = 1;

                        const start = rowsPerPage === 'all' ? 0 : (currentPage - 1) * rowsPerPage;
                        const end = rowsPerPage === 'all' ? totalRows : start + rowsPerPage;

                        rows.forEach((row, index) => {
                            if (index >= start && index < end) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });

                        renderControls(totalPages);
                    }

                    function renderControls(totalPages) {
                        if (!paginationControls) return;
                        paginationControls.innerHTML = '';
                        
                        if (totalPages <= 1) {
                            paginationControls.style.display = 'none';
                            return;
                        }
                        
                        paginationControls.style.display = 'flex';

                        const prevBtn = document.createElement('button');
                        prevBtn.textContent = 'Previous';
                        prevBtn.className = 'page-btn';
                        prevBtn.disabled = currentPage === 1;
                        prevBtn.type = 'button';
                        prevBtn.onclick = (e) => {
                            currentPage--;
                            renderTable();
                        };
                        paginationControls.appendChild(prevBtn);

                        const pageInfo = document.createElement('span');
                        pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
                        pageInfo.className = 'page-info';
                        paginationControls.appendChild(pageInfo);

                        const nextBtn = document.createElement('button');
                        nextBtn.textContent = 'Next';
                        nextBtn.className = 'page-btn';
                        nextBtn.disabled = currentPage === totalPages;
                        nextBtn.type = 'button';
                        nextBtn.onclick = (e) => {
                            currentPage++;
                            renderTable();
                        };
                        paginationControls.appendChild(nextBtn);
                    }

                    if (perPageSelect) {
                        perPageSelect.addEventListener('change', (e) => {
                            const val = e.target.value;
                            rowsPerPage = val === 'all' ? 'all' : parseInt(val, 10);
                            currentPage = 1;
                            renderTable();
                        });
                        
                        // Initial render
                        renderTable();
                    }
                }
            }
        });
    </script>
</body>
</html>
