<!-- resources/views/emails/nft_notification.blade.php -->

@component('mail::message')
    # Thông Báo Nhận NFT

    Chào bạn {{ $userName }},

    Chúc mừng! Bạn vừa nhận được một món quà NFT từ {{ $senderName }}. Dưới đây là thông tin chi tiết về NFT của bạn:

    **Tên NFT:** {{ $nftName }}
    **Mô tả:** {{ $nftDescription }}
    **Đường Dẫn Xem NFT:** [{{$nftUrl}}]

    Hãy kiểm tra ngay và trải nghiệm NFT độc đáo của bạn!

    @component('mail::button', ['url' => $nftUrl])
        Xem NFT
    @endcomponent

    Nếu bạn có bất kỳ câu hỏi hoặc cần hỗ trợ, đừng ngần ngại liên hệ với chúng tôi.

    Cảm ơn bạn đã tham gia cộng đồng của chúng tôi và chúc bạn có những trải nghiệm thú vị với NFT của mình.

    Trân trọng,
    Platform Team
@endcomponent
