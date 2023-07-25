<?php

final class MessageScrambler {

    private const SEED = 322;
    private const MAX_MESSAGE_LENGTH = 256;

    public function scramble(string $message): string {
        $message = $this->sanitizeAndSplit($message);
        mt_srand(self::SEED);
        for ($i = count($message) - 1; $i > 0; $i--) {
            $j = mt_rand(0, $i);
            $tmp = $message[$i];
            $message[$i] = $message[$j];
            $message[$j] = $tmp;
        }

        return implode('', $message);
    }

    public function descramble(string $message): string {
        $message = $this->sanitizeAndSplit($message);
        mt_srand(self::SEED);
        $indexes = [];

        for ($i = count($message) - 1; $i > 0; $i--) {
            $indexes[$i] = mt_rand(0, $i);
        }

        $indexes = array_reverse($indexes, true);
        
        foreach ($indexes as $i => $j) {
            $tmp = $message[$i];
            $message[$i] = $message[$j];
            $message[$j] = $tmp;
        }

        return implode('', $message);
    }

    private function sanitizeAndSplit(string $message): array {
        $message = preg_replace('/[^a-z]/i', '', strtolower($message));
        $message = substr($message, 0, self::MAX_MESSAGE_LENGTH);
        $message = str_split($message);

        return $message;
    }
}
