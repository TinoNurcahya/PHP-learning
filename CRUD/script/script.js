const keyword = document.getElementById("keyword");
const dataTable = document.getElementById("dataTable");

keyword.addEventListener("input", () => {
  let value = keyword.value.trim();

  fetch("search_ajax.php?keyword=" + encodeURIComponent(value))
    .then((res) => res.json())
    .then((rows) => {
      if (rows.length === 0) {
        dataTable.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
        return;
      }

      let html = "";
      rows.forEach((row, index) => {
        html += `
          <tr>
            <td>${index + 1}</td>
            <td>${row.nama}</td>
            <td>${row.kategori}</td>
            <td>${row.jumlah}</td>
            <td>${row.lokasi}</td>
            <td>${row.waktu}</td>
            <td><img src="img/${row.gambar}" style="height:100px;" class="rounded-3"></td>
            <td>
              <a href="edit.php?id=${row.id}" class="btn btn-sm btn-warning m-2"><i class="fas fa-edit"></i></a>
              <a href="hapus.php?hapus=${
                row.id
              }" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger m-2"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
        `;
      });

      dataTable.innerHTML = html;
    })
    .catch((err) => console.error(err));
});



//* FILE search_ajax.php sebelum menggunakan API 
// include "check_cookie.php";

// $keyword = $_GET['keyword'] ?? '';
// $where = "";

// if (!empty($keyword)) {
//   $safe_keyword = $koneksi->real_escape_string($keyword);
//   $where = "WHERE nama LIKE '$safe_keyword%' 
//           OR nama LIKE '%$safe_keyword%' 
//           OR kategori LIKE '%$safe_keyword%'";
// }

// $data = $koneksi->query("SELECT * FROM inventaris $where ORDER BY waktu DESC LIMIT 5");

// $no = 1;
// if ($data->num_rows > 0) {
//   while ($row = $data->fetch_assoc()) {
//     echo "<tr>
//       <td>{$no}</td>
//       <td>" . htmlspecialchars($row['nama']) . "</td>
//       <td>" . htmlspecialchars($row['kategori']) . "</td>
//       <td>" . htmlspecialchars($row['jumlah']) . "</td>
//       <td>" . nl2br(htmlspecialchars($row['lokasi'])) . "</td>
//       <td>" . nl2br(htmlspecialchars($row['waktu'])) . "</td>
//       <td><img src='img/" . (!empty($row['gambar']) ? $row['gambar'] : 'default.jpg') . "' style='height:100px;' class='rounded-3'></td>
//       <td>
//         <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
//         <a href='hapus.php?hapus={$row['id']}' onclick=\"return confirm('Yakin hapus?')\" class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a>
//       </td>
//     </tr>";
//     $no++;
//   }
// } else {
//   echo "<tr><td colspan='7' class='text-center text-muted'>Data tidak ditemukan.</td></tr>";
// } 