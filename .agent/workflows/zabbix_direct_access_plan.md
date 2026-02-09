# Rencana Implementasi: Direct Zabbix API Traffic Access

Tujuannya adalah menyederhanakan pengambilan data traffic (RX/TX) dari Zabbix API secara langsung tanpa discovery yang kompleks, menggunakan item ID yang sudah ditentukan.

## 1. Konfigurasi Environment (.env)
Menambahkan credential Zabbix ke file `.env` agar aman dan mudah diubah.

```env
ZABBIX_API_URL=http://10.30.1.15/zabbix/api_jsonrpc.php
ZABBIX_AUTH_TOKEN=5a528bfad53bd5f00c26213a7dca5025572c7c36b1c0d9c567be9044a14110cb
```

## 2. Buat Library Service Baru (Simplified)
Membuat ulang `application/libraries/Zabbix_traffic_service.php` yang hilang/dihapus dengan logika simpler:
- **Direct CURL Requests**: Mengirim request JSON-RPC raw sesuai yang diberikan user.
- **Merge Logic**: Menggabungkan hasil RX dan TX berdasarkan timestamp.
- **Error Handling**: Penanganan error sederhana jika API tidak reachable.

## 3. Update Controller Logic
Memperbarui `application/controllers/Admin/Traffic.php` untuk menggunakan service baru ini.

## 4. Frontend Integration
Verify `application/views/admin/security/network_traffic_mrtg.php` menerima format data yang sesuai (Chart.js/ECharts format).

---
**Status File Saat Ini:**
- `application/libraries/Zabbix_api.php`: (Hilang/Dihapus) -> Tidak perlu dibuat ulang jika logic digabung ke Service.
- `application/libraries/Zabbix_traffic_service.php`: (Hilang/Dihapus) -> Akan dibuat baru.
- `application/config/zabbix.php`: (Hilang) -> Tidak diperlukan jika pakai .env.
