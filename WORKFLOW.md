# IndoTech Development Workflow

Panduan lengkap untuk membuat fitur baru, push, dan merge ke production. Ikuti langkah ini agar semua orang aligned.

---

## 1. Setup Awal (First Time Only)

```bash
# Clone repo
git clone https://github.com/mizhuhara/IndoTech.git
cd IndoTech

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database (MySQL)
php artisan migrate

# Run dev server
php artisan serve
# Buka http://127.0.0.1:8000
```

---

## 2. Membuat Fitur Baru

### Step 1: Buat Branch
```bash
git checkout main
git pull origin main
git checkout -b feature/nama-fitur
```

**Nama branch**: `feature/nama-fitur` (contoh: `feature/user-dashboard`, `feature/payment`)

### Step 2: Develop
Kerjakan fitur di branch baru:
- Edit file
- Buat controller: `php artisan make:controller NamaController`
- Buat model: `php artisan make:model Nama -m` (with migration)
- Buat view di `resources/views/`
- Tambah route di `routes/web.php`

Test lokal:
```bash
php artisan serve
# Akses fitur di browser, cek error
```

### Step 3: Commit
```bash
git add -A
git commit -m "Deskripsi fitur: apa yg ditambah/diubah"
```

**Commit message**: jelas & singkat (contoh: "Tambah halaman user dashboard", "Fix bug login form")

### Step 4: Push ke Remote
```bash
git push -u origin feature/nama-fitur
```

---

## 3. Membuat Pull Request (PR)

```bash
gh pr create --base main --head feature/nama-fitur \
  --title "Judul PR singkat" \
  --body "Deskripsi fitur & perubahan"
```

Atau buka manual di: https://github.com/mizhuhara/IndoTech/pulls → New pull request

---

## 4. Review & Merge

### Untuk Owner/Lead:
1. Buka PR di GitHub
2. Review code & cek tidak ada conflict
3. Approve
4. **Merge ke main**:
   ```bash
   gh pr merge <PR-number> --merge
   ```

### Jika Ada Conflict:
```bash
gh pr checkout <PR-number>
git fetch origin main
git merge origin/main
# Resolve conflict di editor
git add -A
git commit -m "Resolve conflict dengan main"
git push origin feature/nama-fitur
# Retry merge
gh pr merge <PR-number> --merge
```

---

## 5. Update Local Setelah Merge

Semua orang (termasuk yang tidak membuat PR):
```bash
git checkout main
git pull origin main
```

Cek fitur baru:
```bash
php artisan serve
# Buka http://127.0.0.1:8000
```

---

## 6. Rollback (Jika Ada Kesalahan)

### Undo Commit Belum Push
```bash
git reset --soft HEAD~1   # Undo commit, file tetap
git reset --hard HEAD~1   # Undo commit + file hilang
```

### Undo Commit Sudah Push
```bash
git revert <commit-hash>
git push origin feature/nama-fitur
```

### Undo PR Sudah Merged
```bash
gh pr revert <PR-number>
```

---

## 7. Command Useful

### Lihat Status
```bash
git status           # File yang berubah
git log --oneline    # History commit
git branch -a        # Semua branch lokal & remote
```

### Lihat PR
```bash
gh pr list           # Semua PR
gh pr view <number>  # Detail PR tertentu
gh pr checks <number> # Status checks PR
```

### Sync dengan Remote
```bash
git fetch origin              # Tarik update dari GitHub
git pull origin main          # Tarik & merge main
git pull --rebase origin main # Tarik & rebase (history clean)
```

---

## 8. Best Practices

✅ **DO:**
- Buat branch baru untuk setiap fitur
- Commit sering dengan pesan jelas
- Pull request sebelum merge ke main
- Coordinate dengan tim sebelum push ke production
- Test lokal sebelum push

❌ **DON'T:**
- Push langsung ke main (gunakan PR)
- Commit tanpa pesan
- Merge tanpa resolve conflict
- Push tanpa test lokal
- Change main branch history (reset --hard)

---

## 9. Workflow Summary

```
1. git checkout -b feature/nama-fitur
2. Kerjakan fitur + commit
3. git push -u origin feature/nama-fitur
4. gh pr create ... (atau buat PR manual)
5. Owner: review & approve
6. gh pr merge <number> --merge
7. Semua: git checkout main && git pull origin main
8. Test di http://127.0.0.1:8000
```

---

## 10. Kontak & Questions

Jika ada pertanyaan atau stuck:
- Tanya di grup/chat tim
- Cek dokumentasi Laravel: https://laravel.com/docs
- Cek git docs: https://git-scm.com/doc

---

**Last Updated**: 2026-08-31
**Team**: IndoTech Dev Team
