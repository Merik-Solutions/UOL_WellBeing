<?php

return [
    /**
     * API Token Key (string)
     * Accepted value:
     * Live Token: https://myfatoorah.readme.io/docs/live-token
     * Test Token: https://myfatoorah.readme.io/docs/test-token
     */
    'api_key' => env(
        'MYFATOORAH_API_KEY',
        'BWkbBe1LUAdyw6DLBZebgk4XPgZftDs96ZY_IoCIuRcrkk1M4B-ptn5vKNtavMp6VK3EqhM-RM5dfDfi0RxMrnP4LUZnrNd1X_NxUykdG_F5LiM8kxHlXOgSDNcsaKfXKxJ1XcQ2hat45y9N5Vt-ZRGCaH2nA5gtZY8PCGAPpid-uIkfgb6EExVacDhRSC3lro8n9-ymArcwUUWEhHSBbZDybqjAXGUEzLVNuKGWw5glQ3yG_hYfAsXhl7E-41e0xta_3YOIAjVTE-VdEDRzwGFzcsFdjYE0xk9blp2BCxmglYg24fMeoU63zpYqBZWv1lNar9Nm3UPMKNAxFCxh5S4-3-YF1MRgFfwweWI_VlwYtWYqgoouPianLtvJuPycxJLViLWB7AgcrdThrZS7-9W6qJ2guY-D6D4E8GSUQN36BYi--_9joM-ZWf1v0nno4imkErF0GYS6wpfkj6aaDNfM8rX7pcC2Afx_cdZD38_y3dNlSjSmfvzg4i8yw0KmuuPQsZeaVPUqfLOtTSOgeB4hTx29Lr_xQmawj43qNWfromomiqx_xZoceao9P-KC0qiiiRWtXfoMBqk3QgSIE9IYsdrCZxz-6of9gwDyFVBbdIIEN_WXwU44CoDAuRTSopFHK7s7xRQewtBW4oQ_XFn1VdA6gGHMYXc-62bNxg2r9WR1',
    ),
    /**
     * Test Mode (boolean)
     * Accepted value: true for the test mode or false for the live mode
     */
    'test_mode' => env('MYFATOORAH_TEST_MODE', true),
    /**
     * Country ISO Code (string)
     * Accepted value: KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY.
     */
    'country_iso' => env('MYFATOORAH_COUNTRY_ISO', 'SAU'),
    'country_currency' => env('MYFATOORAH_CURRENCY', 'SAR'),
];
