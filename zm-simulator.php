<?php
/*
 * BSD 3-Clause License
 *
 * Copyright (c) 2024, TASoft Applications
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 *  Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 *  Neither the name of the copyright holder nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

use Ikarus\SPS\Register\CommonTCPMemoryRegister;

require "vendor/autoload.php";

restart:
echo "START\n";

$MR = new CommonTCPMemoryRegister('creg-160', '192.168.200.1', 9090, false);

echo "WARTE AUF KOMMANDO ZM.RESET: ";

while (1) {
    try {
        if($MR->getCommand("ZM.RESET")) {
            echo "OK\n";
            echo "LADE WERT ZM.WERT_1, ADDIERE +1\n";
            $audio = $MR->fetchValue("ZM", 'WERT_1');
            $audio += 1;
            $MR->putValue($audio, "WERT_1", "ZM");
            echo "WARTE 3 SEKUNDEN\n";
            sleep(3);

            echo "SETZE KOMMANDO ZM.BEREIT UND LÖSCHE KOMMANDO ZM.RESET\n";
            $MR->putCommand("ZM.BEREIT", '1');
            $MR->clearCommand('ZM.RESET');

            echo "WARTE AUF SPIELSTART: ";
        }

        if($MR->getCommand('ZM.START')) {
            echo "OK\n";
            echo "SETZE STATUS DER ZEITMASCHINE zm AUF EIN\n";
            $MR->setStatus(2, 'zm');

            echo "WARTE 3 SEKUNDEN\n";
            sleep(3);

            echo "SETZE STATUS DER ZEITMASCHINE zm AUF AUS\n";
            $MR->setStatus(1, 'zm');

            echo "SETZE KOMMANDO ZM.FERTIG UND LÖSCHE KOMMANDO ZM.START\n";
            $MR->putCommand("ZM.FERTIG", '1');
            $MR->clearCommand('ZM.START');

            echo "PROZESS BEENDET.\nWARTE AUF KOMMANDO ZM.RESET: ";
        }
    } catch (Throwable $exception) {
        sleep(1);
        goto restart;
    }

    sleep(1);
}