<?php

namespace Tests\Feature\Operations;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OutgoingSSLCurlTest extends TestCase
{
    /**
     * A basic test to check whether the curl extension is properly enabled and configured.
     * 
     * If not, set in php.ini the absolute path to an cacert.pem-file
     * 
     * [curl]
     * ; A default value for the CURLOPT_CAINFO option. This is required to be an
     * ; absolute path.
     * curl.cainfo = "C:\php\extras\ssl\cacert.pem"
     *
     * @return void
     */
    public function testCurlWithSSL()
    {
        //step1
        $cSession = curl_init();
        //step2
        curl_setopt($cSession,CURLOPT_URL,"https://news.orf.at");
        curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($cSession,CURLOPT_HEADER, false);

        //step3
        curl_exec($cSession);

        $this->assertEquals(0, curl_errno($cSession));

        //step4
        curl_close($cSession);
    }
}
