@extends('layouts.app')

@section('title', 'Help')

@section('content')
<div class="help-container">
    <h2 class="help-title">Bantuan & Dukungan</h2>
    
    <div class="help-section">
        <h3 class="section-title">Pertanyaan yang Sering Diajukan</h3>
        
        <div class="faq-item">
            <div class="faq-question">
                <span>Bagaimana cara menambahkan tugas baru?</span>
                <span>+</span>
            </div>
            <div class="faq-answer">
                Untuk menambahkan tugas baru, klik menu "Tambah Tugas" di sidebar. Kemudian isi form yang tersedia dengan detail tugas Anda.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Bagaimana cara mengubah status tugas?</span>
                <span>+</span>
            </div>
            <div class="faq-answer">
                Anda dapat mengubah status tugas dengan membuka detail tugas dan memilih status yang diinginkan dari dropdown menu.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Apakah saya bisa mengubah foto profil?</span>
                <span>+</span>
            </div>
            <div class="faq-answer">
                Ya, Anda dapat mengubah foto profil di halaman Settings. Klik tombol "Ubah Foto" di bagian profil.
            </div>
        </div>
    </div>

    <div class="help-section">
        <h3 class="section-title">Hubungi Kami</h3>
        <div class="contact-info">
            <div class="contact-item">
                <div class="contact-icon">📧</div>
                <div class="contact-text">
                    Email: <a href="mailto:support@taskflow.com">support@taskflow.com</a>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">📱</div>
                <div class="contact-text">
                    WhatsApp: <a href="https://wa.me/6281234567890">+62 812-3456-7890</a>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">🌐</div>
                <div class="contact-text">
                    Website: <a href="https://taskflow.com">www.taskflow.com</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .help-container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        min-height: calc(100vh - 110px);
        width: 100%;
    }

    .help-title {
        color: #333;
        margin-bottom: 2rem;
        font-size: 1.5rem;
        border-bottom: 2px solid #0487FF;
        padding-bottom: 0.5rem;
        display: inline-block;
    }

    .help-section {
        margin-bottom: 2rem;
    }

    .section-title {
        color: #0487FF;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .faq-item {
        margin-bottom: 1.5rem;
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        overflow: hidden;
    }

    .faq-question {
        background-color: #f8f9fa;
        padding: 1rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-question:hover {
        background-color: #f0f0f0;
    }

    .faq-answer {
        padding: 1rem;
        display: none;
        border-top: 1px solid #e1e1e1;
    }

    .faq-item.active .faq-answer {
        display: block;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background-color: #87CEEB;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .contact-text {
        color: #333;
    }

    .contact-text a {
        color: #0487FF;
        text-decoration: none;
    }

    .contact-text a:hover {
        text-decoration: underline;
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            faqItem.classList.toggle('active');
            
            // Toggle icon
            const icon = question.querySelector('span:last-child');
            icon.textContent = faqItem.classList.contains('active') ? '-' : '+';
        });
    });
</script>
@endpush 