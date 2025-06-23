<!-- resources/views/admin/users.blade.php -->
 <x-layouts.app>
<div class="p-6">
    @livewire('user-management')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('swal:toast', ({ type, message }) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#1e293b', // dark mode background
                color: '#fff'
            });
        });
    });
</script>

</x-layouts.app>
