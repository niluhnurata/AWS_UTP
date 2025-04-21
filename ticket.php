<?php

class Ticket {
    private $ticketId;
    private $ticketType;

    public function __construct($ticketType) {
        // Ambil ticketCounter dari sesi atau default ke 1 jika belum ada
        $ticketCounter = isset($_SESSION['ticketCounter']) ? $_SESSION['ticketCounter'] : 1;
        
        // Set ticketId dengan counter yang ada di sesi
        $this->ticketId = $ticketCounter;
        
        // Update ticketCounter di sesi untuk penggunaan berikutnya
        $_SESSION['ticketCounter'] = $ticketCounter + 1;
        
        $this->ticketType = $ticketType;
    }

    public function getTicketId() {
        return $this->ticketId;
    }

    public function getTicketType() {
        return $this->ticketType;
    }

    public function getTicketStatus() {
        return "Created"; // Status tiket saat dibuat
    }
}