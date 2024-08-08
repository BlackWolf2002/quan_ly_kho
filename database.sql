


INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `dia_chi`, `gioi_tinh`, `sdt`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$p7c4BxUf1Y/hDwOgBvzwleQRNwBuyFBWPDMXv5lQeFqHR0HkGKtQG', 'avatar.jpg', NULL, 'Ẩn', NULL, 1, NULL, '2023-04-06 10:14:43', '2023-04-06 10:14:43');

INSERT INTO `trang_thai` (`id`, `ten_trang_thai`, `created_at`, `updated_at`) VALUES
(1, 'Private', NULL, NULL),
(2, 'Pending', NULL, NULL),
(3, 'Public', NULL, NULL);

INSERT INTO `nha_cung_cap` (`id`, `ma_ncc`, `ten_ncc`, `id_trang_thai`, `dia_chi`, `sdt`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'B01', 'Bình', 3, 'Sông Công', 356627865, 'ok\n', '2023-04-06 10:16:05', '2023-04-06 10:16:05');


INSERT INTO `loai_hang` (`id`, `ten_loai_hang`, `id_trang_thai`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Thực phẩm', 3, 'ok\n', '2023-04-06 10:16:34', '2023-04-06 10:16:34');


INSERT INTO `hang_hoa` (`id`, `ma_hang_hoa`, `ten_hang_hoa`, `mo_ta`, `id_loai_hang`, `don_vi_tinh`, `barcode`, `img`, `created_at`, `updated_at`) VALUES
(1, 'MT01', 'Mì tôm hảo hảo', 'ok\n', 1, 'Gói', 123123123, '1680776320.png', '2023-04-06 10:18:40', '2023-04-06 10:18:40');

INSERT INTO `phieu_nhap` (`id`, `ma_phieu_nhap`, `id_user`, `ma_ncc`, `ngay_nhap`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'PN000001', 1, 'B01', '2023-04-06', 'ok\n', '2023-04-06 10:19:37', '2023-04-06 10:19:37');

INSERT INTO `chi_tiet_hang_hoa` (`id`, `ma_phieu_nhap`, `ma_hang_hoa`, `ma_ncc`, `so_luong`, `so_luong_goc`, `id_trang_thai`, `gia_nhap`, `ngay_san_xuat`, `tg_bao_quan`, `created_at`, `updated_at`) VALUES
(1, 'PN000001', 'MT01', 'B01', 90, 100, 3, 4000, '2023-04-06', 24, '2023-04-06 10:19:37', '2023-04-06 10:20:38');

INSERT INTO `phieu_xuat` (`id`, `ma_phieu_xuat`, `khach_hang`, `dia_chi`, `ngay_xuat`, `mo_ta`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'PX000001', 'Hải', 'Đại Từ', '2023-04-06', 'ok\n', 1, '2023-04-06 10:20:38', '2023-04-06 10:20:38');


INSERT INTO `chi_tiet_phieu_xuat` (`id`, `ma_phieu_xuat`, `id_chi_tiet_hang_hoa`, `so_luong`, `gia_xuat`, `created_at`, `updated_at`) VALUES
(1, 'PX000001', 1, 10, 5000, '2023-04-06 10:20:38', '2023-04-06 10:20:38');













