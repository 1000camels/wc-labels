<?php
// #########################################################
// #                     PHP Signing                       #
// #########################################################
// Sample key.  Replace with one used for CSR generation
$KEY_STRING = '-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDHiGZXDwwWoJ24
WvkN8c6iQRDo5dyvTSzLVjk7NBnARcyV6oPtF0wYVmbL/mV668r36Wbt0nm0M+Xi
LYzCP9SyJy5yZjoaKCod+UB/H4lzq527CnEVDiTOISSh231EBCl8NSSVO2BqXNKj
IAwd+leXuf3Z4u5kcbWttV8d1K4RL1thPsjr4KdwczRYdL75OJir3MWLCP1WNyLm
Q2AxHDwDPJ8sE0glgtSUMNxyDOV1JiEG3BYmEbxnBLhL6Z7CvdyM5zyOKmbHGKg0
WlM+O4SolSkWn03buHujGBAzrhYTPm82OVMBxBvKSqBqjp5aGgG8c1zYM8sPe3Rn
7jNzss3hAgMBAAECggEARIlelcLOZStQYZWl/Js1Xdg5pbXm4rQAkeuRBvvzaG7R
QiFmpVaeRbHP53v/gYRimFsshr4IHdTBvrnkoohoV7VLp/HjPT7UkK0f8Up03S1y
pV+FzjSogcEyowIQef9v/IEIitX1XTN7CpskbluiILS7NE9VkVzZicxF2qpGDBJ7
pVvjzxw70miWtXi3uUzq4shQGCMCVkyMsRm8T3A+RVTDKoPnKDLplFLCANugyfOU
8qvW4eJT4mqN7g5pHw9D82rvt1aPuGxb0c8g44o+20+iDkpPy5oFD1vRQqTuMlws
tJeSgKyAx3X/7EbUsQRZcYaC3eFtpwu+//JST8jn/QKBgQDwHGx4xQm65l2gYR1c
M5NAnULnzPpbRzKR3RxrPEl8cw7NASNGKC+QcOWezruu2KMjts9TJRLaWcSJUsT3
jwz0GVfMAtNyRD5yP2a9pM8nFFTKv8fBv4vwM87gOXTjQ9KEa9xk12hkO4vv3vHG
4TeMEehsm3IE+lalq7CoYyl2/wKBgQDUvJCdJys6HQUh5vL6cXBNRKmMxGECDE0Z
QZOF0zZIACNaVeO9qgL4Lh3OF50dkxRz40+llkyRu5IJakr5uYmjvntU/2bAHpgR
My5NdS2zOnNqCsfI0OFyRmpgOXk50tciOKizzOmmBaTY+1j2FoOzecGlTSQUnR3q
XKc70l+bHwKBgFD8tVWS2DJTKzdCKl4EA2Hi6UM4LyWEgTkTxFcjMYIpaM+a16P9
P/XPLpP/FOznozcTnSBlO9OsPY83/LmnZW4b8jIcrec3v3xXiDblFP4QbH0qbJ0c
F35Aa0HT/2n8YVBK9T6KLWrJbuzMXO6A3nR/Qc8IK1Akg/9DRsW1FLJPAoGBAITi
OI8BzX2ibPdNVM9dlqGdVy9n55So7GvvS2AXm9uDwpGF/xkVHn+6BsIae/jiS69L
+Q9c//00JjedXrH41GIk9NMWKi+trJ1p0+1sWZyP0VIW486rs3d3RrFOlUuqSNnG
fJK7V+NtuRgUgPBPBftQ/cXslrINpocjUw8KDNBPAoGAGILNhNoAHjS41x/SlqIK
FellDW5OFcZxnjR1QBQaQeCb3P2op8XV0tibarRmFLu7dB+5Ao+Ap+YRuhEamIRD
iSuP31csJ2SPEuGpPyi+C+/F5Oc+IlpoKsNa2UtF/A6NMIMTouL9RbZ7c70xMF3u
5WKcONmiF48aEgSs4RDhzvw=
-----END PRIVATE KEY-----';


$req = $_POST['request']; //POST method


$privateKey = openssl_get_privatekey($KEY_STRING);

$signature = null;
openssl_sign($req, $signature, $privateKey);

if ($signature) {
   header("Content-type: text/plain");
   echo base64_encode($signature);
   exit(0);
}

echo '<h1>Error signing message</h1>';
exit(1);