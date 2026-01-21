# Log Perbaikan Error

## Error #1: http_response_code() Undefined Function

**Tanggal:** 21 Januari 2026

### ❌ Error Message
```
Fatal error: Call to undefined function http_response_code() 
in C:\xampp\htdocs\MVC-PHP-5-TEMPLATE\app\core\App.php on line 62
```

### 🔍 Analisa

**Penyebab:**
- Fungsi `http_response_code()` baru tersedia sejak **PHP 5.4.0**
- Template ini dirancang untuk mendukung **PHP 5.2+**
- PHP 5.2 dan 5.3 tidak memiliki fungsi `http_response_code()`

**Lokasi Error:**
- File: `app/core/App.php`
- Line: 62
- Kode: `http_response_code(404);`

**Fungsi yang Bermasalah:**
```php
// Di App.php line 62
http_response_code(404);
echo "Route not found for $method $requestUri.";
```

### ✅ Solusi

**1. Tambahkan Polyfill Function di Config.php**

Menambahkan polyfill (fallback) function untuk `http_response_code()` yang akan otomatis digunakan jika PHP version < 5.4:

```php
// Di app/core/Config.php

if (!function_exists('http_response_code')) {
    function http_response_code($code = NULL) {
        if ($code !== NULL) {
            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 200: $text = 'OK'; break;
                case 404: $text = 'Not Found'; break;
                case 500: $text = 'Internal Server Error'; break;
                // ... dan status code lainnya
                default:
                    exit('Unknown http status code');
                break;
            }
            
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? 
                        $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            header($protocol . ' ' . $code . ' ' . $text);
            $GLOBALS['http_response_code'] = $code;
        } else {
            $code = (isset($GLOBALS['http_response_code']) ? 
                    $GLOBALS['http_response_code'] : 200);
        }
        
        return $code;
    }
}
```

**2. Cara Kerja Polyfill:**

- `if (!function_exists('http_response_code'))` - Cek apakah fungsi sudah ada
- Jika PHP >= 5.4, fungsi native akan digunakan
- Jika PHP < 5.4, polyfill kita akan digunakan
- Polyfill menggunakan `header()` untuk set HTTP status code
- Support HTTP status codes: 100, 200, 201, 404, 500, dll

**3. Keuntungan Solusi Ini:**

✅ **Kompatibel** dengan PHP 5.2, 5.3, 5.4, 7.x, 8.x  
✅ **Tidak mengubah** kode di App.php  
✅ **Automatic fallback** - PHP otomatis pilih fungsi yang sesuai  
✅ **Standard compliant** - Menggunakan HTTP status code standar  

### 🧪 Testing

**Test di PHP 5.2/5.3:**
```bash
php -v
# PHP 5.2.x atau 5.3.x

# Akses route yang tidak ada
curl -I http://localhost/MVC-PHP-5-TEMPLATE/route-tidak-ada

# Output:
# HTTP/1.0 404 Not Found
```

**Test di PHP 5.4+:**
```bash
php -v
# PHP 5.4+ / 7.x / 8.x

# Akses route yang tidak ada
curl -I http://localhost/MVC-PHP-5-TEMPLATE/route-tidak-ada

# Output:
# HTTP/1.1 404 Not Found
```

### 📋 File yang Diubah

1. **app/core/Config.php**
   - ✅ Ditambahkan polyfill function `http_response_code()`
   - ✅ Support semua HTTP status codes
   - ✅ Kompatibel PHP 5.2+

### 🎯 Status
✅ **FIXED** - Error sudah diperbaiki dan tested

---

## Fungsi PHP Lain yang Perlu Polyfill (Optional)

Berikut fungsi-fungsi PHP modern yang mungkin perlu polyfill jika ingin support PHP 5.2:

### 1. array_column() - Tersedia sejak PHP 5.5
```php
if (!function_exists('array_column')) {
    function array_column($array, $column_key, $index_key = null) {
        $result = array();
        foreach ($array as $arr) {
            if (!is_array($arr)) continue;
            
            if (is_null($column_key)) {
                $value = $arr;
            } else {
                $value = $arr[$column_key];
            }
            
            if (!is_null($index_key)) {
                $key = $arr[$index_key];
                $result[$key] = $value;
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }
}
```

### 2. password_hash() dan password_verify() - Tersedia sejak PHP 5.5
```php
if (!function_exists('password_hash')) {
    function password_hash($password, $algo, $options = array()) {
        $salt = isset($options['salt']) ? $options['salt'] : '';
        $cost = isset($options['cost']) ? $options['cost'] : 10;
        
        if (empty($salt)) {
            $salt = substr(md5(uniqid(rand(), true)), 0, 22);
        }
        
        return crypt($password, '$2y$' . $cost . '$' . $salt);
    }
}

if (!function_exists('password_verify')) {
    function password_verify($password, $hash) {
        return crypt($password, $hash) === $hash;
    }
}
```

### 3. json_last_error_msg() - Tersedia sejak PHP 5.5
```php
if (!function_exists('json_last_error_msg')) {
    function json_last_error_msg() {
        static $errors = array(
            JSON_ERROR_NONE => 'No error',
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters'
        );
        
        $error = json_last_error();
        return array_key_exists($error, $errors) ? $errors[$error] : 'Unknown error';
    }
}
```

---

## Checklist Fungsi PHP untuk Compatibility

| Fungsi | PHP Version | Status | Polyfill Needed |
|--------|-------------|--------|-----------------|
| `http_response_code()` | 5.4+ | ✅ Fixed | Yes |
| `array_column()` | 5.5+ | ⚠️ Optional | If needed |
| `password_hash()` | 5.5+ | ⚠️ Optional | If needed |
| `password_verify()` | 5.5+ | ⚠️ Optional | If needed |
| `json_last_error_msg()` | 5.5+ | ⚠️ Optional | If needed |
| `boolval()` | 5.5+ | ⚠️ Optional | If needed |
| `hash_equals()` | 5.6+ | ⚠️ Optional | If needed |

---

## Best Practices untuk PHP 5.2+ Compatibility

1. **Selalu cek function existence**
   ```php
   if (!function_exists('function_name')) {
       // Polyfill implementation
   }
   ```

2. **Gunakan traditional array syntax**
   ```php
   // Good - PHP 5.2+
   $array = array('key' => 'value');
   
   // Bad - PHP 5.4+ only
   $array = ['key' => 'value'];
   ```

3. **Hindari short echo tags jika memungkinkan**
   ```php
   // Good - always works
   <?php echo $var; ?>
   
   // Bad - requires short_open_tag=On
   <?= $var ?>
   ```

4. **Test di multiple PHP versions**
   - PHP 5.2 (oldest)
   - PHP 5.6 (last 5.x)
   - PHP 7.4 (last 7.x)
   - PHP 8.2 (current)

---

**Status:** ✅ Error fixed dan documented
**Updated:** 21 Januari 2026

---

## Error #2: Route Not Found untuk Root Path

**Tanggal:** 21 Januari 2026

### ❌ Error Message
```
Route not found for GET .
```

### 🔍 Analisa

**Penyebab:**
- `FOLDER_PROJECT` di Config.php memiliki **trailing slash**: `'MVC-PHP-5-TEMPLATE/'`
- Saat processing URI, trailing slash menyebabkan empty string atau dot (`.`)
- Route tidak match karena mencari `.` bukan `/`

**Contoh:**
```php
// Config.php
define('FOLDER_PROJECT', 'MVC-PHP-5-TEMPLATE/');  // ❌ Dengan trailing slash

// App.php processing
$requestUri = '/MVC-PHP-5-TEMPLATE/';
$requestUri = str_replace('/MVC-PHP-5-TEMPLATE/', '', '/MVC-PHP-5-TEMPLATE/');
// Result: '' (empty string) atau '.' tergantung PHP version
```

**Lokasi Error:**
- File: `app/core/Config.php` - FOLDER_PROJECT definition
- File: `app/core/App.php` - URI processing

### ✅ Solusi

**1. Perbaiki FOLDER_PROJECT di Config.php**

```php
// SEBELUM (❌ Error)
define('FOLDER_PROJECT', 'MVC-PHP-5-TEMPLATE/');

// SESUDAH (✅ Fixed)
define('FOLDER_PROJECT', 'MVC-PHP-5-TEMPLATE');
```

**2. Perbaiki URI Processing di App.php**

```php
// Normalize FOLDER_PROJECT - hapus trailing slash jika ada
$folderProject = rtrim(FOLDER_PROJECT, '/');

// Hilangkan base folder dari URI
$requestUri = str_replace('/' . $folderProject, '', $requestUri);

// Jika URI kosong atau hanya slash, set sebagai '/'
if (empty($requestUri)) {
    $requestUri = '/';
}
```

**3. Keuntungan Solusi:**

✅ **Flexible** - Handle dengan atau tanpa trailing slash  
✅ **Normalize** - Selalu menghasilkan URI yang konsisten  
✅ **Safe** - Empty string otomatis jadi `/`  
✅ **Backward compatible** - Tidak break existing code  

### 🧪 Testing

**Test route root:**
```bash
# Test akses home
http://192.168.1.240/MVC-PHP-5-TEMPLATE/
# Expected: HomeController@index dipanggil

# Test dengan trailing slash
http://192.168.1.240/MVC-PHP-5-TEMPLATE
# Expected: Tetap bekerja (redirect atau serve)
```

### 📋 File yang Diubah

1. **app/core/Config.php**
   - ✅ Hapus trailing slash dari FOLDER_PROJECT
   - ✅ Konsistensi naming

2. **app/core/App.php**
   - ✅ Tambah normalization dengan `rtrim()`
   - ✅ Handle empty URI case
   - ✅ Set default `/` untuk root path

### 🎯 Status
✅ **FIXED** - Route sekarang berfungsi dengan benar

---

**Status:** ✅ All errors fixed dan documented
**Updated:** 21 Januari 2026
