<?php
require('ticket.php');

session_start(); 

class TicketsService {
    private $tickets = [];

    public function __construct() {
        // Inisialisasi tiket jika belum ada dalam sesi
        if (!isset($_SESSION['tickets'])) {
            $_SESSION['tickets'] = [];
        }

        // Inisialisasi purchaseCount jika belum ada dalam sesi
        if (!isset($_SESSION['purchaseCount'])) {
            $_SESSION['purchaseCount'] = 0;
        }
    }

    public function buyTicket() {
        $_SESSION['purchaseCount']++; // Increment purchase count

        // Jika sudah lebih dari 1 kali beli tiket (pembelian ke-2 dan seterusnya), kasih cashback
        if ($_SESSION['purchaseCount'] > 1) {
            return $this->issueTicketAndCashBack();
        } else {
            // Jika pembelian pertama, hanya dapatkan tiket
            return $this->issueTicket();
        }
    }

    public function issueTicket() {
        // Mengeluarkan tiket pertama dan menghapusnya dari daftar tiket
        if (!empty($_SESSION['tickets'])) {
            $ticket = array_shift($_SESSION['tickets']); // Mengambil dan menghapus tiket pertama
            return [
                "success" => true,
                "message" => "Selamat! Anda mendapatkan tiket.",
                "ticket" => "Tiket ID: " . $ticket->getTicketId()
            ];
        } else {
            return [
                "success" => false,
                "message" => "Tidak ada tiket yang tersedia. Silakan buat tiket terlebih dahulu.",
                "ticket" => "Tidak ada"
            ];
        }
    }

    public function issueTicketAndCashBack() {
        // Mengeluarkan tiket dan cashback
        if (!empty($_SESSION['tickets'])) {
            $ticket = array_shift($_SESSION['tickets']); // Mengambil dan menghapus tiket pertama
            return [
                "success" => true,
                "message" => "Selamat! Anda mendapatkan tiket dan cashback.",
                "ticket" => "Tiket ID: " . $ticket->getTicketId(),
                "cashback" => "Diberikan"
            ];
        } else {
            return [
                "success" => false,
                "message" => "Tidak ada tiket yang tersedia. Silakan buat tiket terlebih dahulu.",
                "ticket" => "Tidak ada",
                "cashback" => "Tidak ada"
            ];
        }
    }
    
    public function createTicket($ticketType) {
        $ticket = new Ticket($ticketType);
        $_SESSION['tickets'][] = $ticket; // Simpan tiket di dalam sesi
        
        return [
            "ticketId" => $ticket->getTicketId(),
            "ticketStatus" => $ticket->getTicketStatus()
        ];
    }
}

// Handle permintaan SOAP
function handleRequest() {
    $server = new SoapServer("saving.wsdl");
    $server->setClass("TicketsService");
    $server->handle();
}

handleRequest();