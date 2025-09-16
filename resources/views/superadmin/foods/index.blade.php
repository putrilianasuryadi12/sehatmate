@extends('layouts.superadmin')

@section('title', 'Halaman Data Makanan')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Halaman Data Makanan</h1>

            <!-- Search Bar and Filter Controls -->
            <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <!-- Search Bar -->
                <div class="relative max-w-md">
                    <input type="text"
                           id="search-makanan"
                           placeholder="Cari Makanan"
                           class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Filter Tabs and Add Button -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex space-x-1">
                        <button onclick="filterMakanan('semua')"
                                id="btn-semua"
                                class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-100 text-blue-700 border border-blue-200">
                            Semua Makanan
                        </button>
                        <button onclick="filterMakanan('saya')"
                                id="btn-saya"
                                class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 border border-gray-200 hover:bg-gray-200 transition-colors">
                            Makanan Saya
                        </button>
                    </div>
                    <a href="{{ route('superadmin.foods.create') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200 text-sm font-medium">
                        Tambah Makanan
                    </a>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th onclick="sortTableByName()" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Nama Makanan <span id="name-sort-indicator">▲</span>
                            </th>
                            <th onclick="sortTableByAuthor()" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Author <span id="author-sort-indicator">▲</span>
                            </th>
                            <th onclick="sortTableByDate()" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Tanggal Add Makanan
                                <span id="date-sort-indicator">▲</span>
                            </th>
                            <th onclick="sortTableByStatus()" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Status <span id="status-sort-indicator">▲</span>
                            </th>
                            <th class="action-header px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="food-table-body">
                        @foreach ($foods as $food)
                        <tr class="hover:bg-gray-50 transition-colors duration-200" data-author="{{ $food->created_by ?? 0 }}" data-current-user="{{ auth()->id() }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('superadmin.foods.show', $food) }}"
                                   class="text-sm font-medium text-blue-600 hover:text-blue-900 hover:underline transition-colors">
                                    {{ $food->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $food->author_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $food->created_at ? $food->created_at->format('d M Y') : '27 September 2025' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ ($food->status ?? 'published') == 'published' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ($food->status ?? 'published') == 'published' ? 'Published' : 'Unpublished' }}
                                </span>
                            </td>
                            <td class="action-cell px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(auth()->user()->role === 'superadmin' || $food->created_by == auth()->id())
                                <div class="flex space-x-4">
                                    <a href="{{ route('superadmin.foods.edit', $food) }}"
                                       class="text-blue-600 hover:text-blue-900 transition-colors">
                                        Edit
                                    </a>
                                    <form class="delete-food-form inline-block" action="{{ route('superadmin.foods.destroy', $food) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for filtering and search -->
<script>
let currentFilter = 'semua';
let dateSortAsc = true;
let nameSortAsc = true;
let authorSortAsc = true;
let statusSortAsc = true;

function filterMakanan(type) {
    currentFilter = type;

    // Update button styles
    const btnSemua = document.getElementById('btn-semua');
    const btnSaya = document.getElementById('btn-saya');

    if (type === 'semua') {
        btnSemua.className = 'px-4 py-2 text-sm font-medium rounded-lg bg-blue-100 text-blue-700 border border-blue-200';
        btnSaya.className = 'px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 border border-gray-200 hover:bg-gray-200 transition-colors';
    } else {
        btnSemua.className = 'px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 border border-gray-200 hover:bg-gray-200 transition-colors';
        btnSaya.className = 'px-4 py-2 text-sm font-medium rounded-lg bg-blue-100 text-blue-700 border border-blue-200';
    }

    // Apply filter
    applyFilter();
    toggleActionColumn();
}

function applyFilter() {
    const rows = document.querySelectorAll('#food-table-body tr');
    const searchTerm = document.getElementById('search-makanan').value.toLowerCase();

    rows.forEach(row => {
        const foodName = row.querySelector('td:first-child a').textContent.toLowerCase();
        const authorId = row.getAttribute('data-author');
        const currentUserId = row.getAttribute('data-current-user');

        let showRow = true;

        // Apply search filter
        if (searchTerm && !foodName.includes(searchTerm)) {
            showRow = false;
        }

        // Apply author filter
        if (currentFilter === 'saya') {
            if (authorId !== currentUserId) {
                showRow = false;
            }
        }

        row.style.display = showRow ? '' : 'none';
    });
}

/**
 * Sort table rows by name column (1st column), toggles ascending/descending.
 */
function sortTableByName() {
    const tbody = document.getElementById('food-table-body');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    rows.sort((a, b) => {
        const nameA = a.querySelector('td:first-child a').textContent.toLowerCase();
        const nameB = b.querySelector('td:first-child a').textContent.toLowerCase();
        return nameSortAsc ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
    });
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
    // Toggle sort direction and update indicator
    nameSortAsc = !nameSortAsc;
    document.getElementById('name-sort-indicator').textContent = nameSortAsc ? '▲' : '▼';
    // Clear other indicators
    document.getElementById('author-sort-indicator').textContent = '';
    document.getElementById('date-sort-indicator').textContent = '';
    document.getElementById('status-sort-indicator').textContent = '';
}

/**
 * Sort table rows by author column (2nd column), toggles ascending/descending.
 */
function sortTableByAuthor() {
    const tbody = document.getElementById('food-table-body');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    rows.sort((a, b) => {
        const authorA = a.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const authorB = b.querySelector('td:nth-child(2)').textContent.toLowerCase();
        return authorSortAsc ? authorA.localeCompare(authorB) : authorB.localeCompare(authorA);
    });
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
    // Toggle sort direction and update indicator
    authorSortAsc = !authorSortAsc;
    document.getElementById('author-sort-indicator').textContent = authorSortAsc ? '▲' : '▼';
    // Clear other indicators
    document.getElementById('name-sort-indicator').textContent = '';
    document.getElementById('date-sort-indicator').textContent = '';
    document.getElementById('status-sort-indicator').textContent = '';
}

/**
 * Sort table rows by date column (3rd column), toggles ascending/descending.
 */
function sortTableByDate() {
    const tbody = document.getElementById('food-table-body');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    rows.sort((a, b) => {
        const dateA = new Date(a.querySelector('td:nth-child(3) .text-sm').textContent);
        const dateB = new Date(b.querySelector('td:nth-child(3) .text-sm').textContent);
        return dateSortAsc ? dateA - dateB : dateB - dateA;
    });
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
    // Toggle sort direction and update indicator
    dateSortAsc = !dateSortAsc;
    document.getElementById('date-sort-indicator').textContent = dateSortAsc ? '▲' : '▼';
    // Clear other indicators
    document.getElementById('name-sort-indicator').textContent = '';
    document.getElementById('author-sort-indicator').textContent = '';
    document.getElementById('status-sort-indicator').textContent = '';
}

/**
 * Sort table rows by status column (4th column), toggles ascending/descending.
 */
function sortTableByStatus() {
    const tbody = document.getElementById('food-table-body');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    rows.sort((a, b) => {
        const statusA = a.querySelector('td:nth-child(4) span').textContent.trim().toLowerCase();
        const statusB = b.querySelector('td:nth-child(4) span').textContent.trim().toLowerCase();
        return statusSortAsc ? statusA.localeCompare(statusB) : statusB.localeCompare(statusA);
    });
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
    // Toggle sort direction and update indicator
    statusSortAsc = !statusSortAsc;
    document.getElementById('status-sort-indicator').textContent = statusSortAsc ? '▲' : '▼';
    // Clear other indicators
    document.getElementById('name-sort-indicator').textContent = '';
    document.getElementById('author-sort-indicator').textContent = '';
    document.getElementById('date-sort-indicator').textContent = '';
}

/**
 * Toggle visibility of action column based on filter and user role
 */
function toggleActionColumn() {
    const actionHeader = document.querySelector('.action-header');
    const actionCells = document.querySelectorAll('.action-cell');
    const isSuper = '{{ auth()->user()->role }}' === 'superadmin';
    if (isSuper || currentFilter === 'saya') {
        actionHeader.style.display = '';
        actionCells.forEach(cell => cell.style.display = '');
    } else {
        actionHeader.style.display = 'none';
        actionCells.forEach(cell => cell.style.display = 'none');
    }
}

// Add search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-makanan');
    searchInput.addEventListener('input', applyFilter);

    // Initial sort by name ascending
    const tbodyInit = document.getElementById('food-table-body');
    const rowsInit = Array.from(tbodyInit.querySelectorAll('tr'));
    rowsInit.sort((a, b) => {
        const nameA = a.querySelector('td:first-child a').textContent.toLowerCase();
        const nameB = b.querySelector('td:first-child a').textContent.toLowerCase();
        return nameA.localeCompare(nameB);
    });
    rowsInit.forEach(row => tbodyInit.appendChild(row));
    // Set indicator and prepare for next toggle
    document.getElementById('name-sort-indicator').textContent = '▲';
    nameSortAsc = false;

    toggleActionColumn();
});
</script>

<!-- SweetAlert2 for delete confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-food-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin menghapus makanan ini?',
            text: "Anda tidak dapat membatalkan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
