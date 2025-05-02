<?php
if (!defined('ABSPATH')) {
    exit;
}

// Add SVG support
add_filter('wp_kses_allowed_html', 'lapinopay_allow_svg_tags', 10, 2);
function lapinopay_allow_svg_tags($allowed_tags, $context)
{
    if ($context === 'post') {
        $allowed_tags['svg'] = array(
            'xmlns' => true,
            'width' => true,
            'height' => true,
            'viewbox' => true,
            'fill' => true,
            'class' => true,
        );
        $allowed_tags['path'] = array(
            'd' => true,
            'fill' => true,
            'stroke' => true,
            'stroke-width' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
        );
    }
    return $allowed_tags;
}

// Add this helper function
function lapinopay_get_payment_icon($icon_name, $alt_text)
{
    if ($icon_name === 'shield-check') {
        $icon_url = plugins_url('assets/icons/secure-payment.png', dirname(__FILE__));
        return sprintf(
            '<div class="lapinopay-payment-icon" role="img" aria-label="%s">
                <img src="%s" alt="%s" width="50" style="display: block;">
            </div>',
            esc_attr($alt_text),
            esc_url($icon_url),
            esc_attr($alt_text)
        );
    }
    $svg_icons = array(
        'shield-check' => '<svg width="46" height="38" viewBox="0 0 46 38" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M43 1H7C5.89543 1 5 1.89543 5 3V27C5 28.1046 5.89543 29 7 29H43C44.1046 29 45 28.1046 45 27V3C45 1.89543 44.1046 1 43 1Z" fill="#4AC6B7"/>
            <path d="M43 1H40C40.5304 1 41.0391 1.21071 41.4142 1.58579C41.7893 1.96086 42 2.46957 42 3V27C42 27.5304 41.7893 28.0391 41.4142 28.4142C41.0391 28.7893 40.5304 29 40 29H43C43.5304 29 44.0391 28.7893 44.4142 28.4142C44.7893 28.0391 45 27.5304 45 27V3C45 2.46957 44.7893 1.96086 44.4142 1.58579C44.0391 1.21071 43.5304 1 43 1Z" fill="#37B7A4"/>
            <path d="M45 6H5V13H45V6Z" fill="#29A892"/>
            <path d="M45 6H42V13H45V6Z" fill="#1B967E"/>
            <path d="M37 24C38.6569 24 40 22.6569 40 21C40 19.3431 38.6569 18 37 18C35.3431 18 34 19.3431 34 21C34 22.6569 35.3431 24 37 24Z" fill="#FFBC5A"/>
            <path d="M32 24C33.6569 24 35 22.6569 35 21C35 19.3431 33.6569 18 32 18C30.3431 18 29 19.3431 29 21C29 22.6569 30.3431 24 32 24Z" fill="#E05555"/>
            <path d="M9.0026 37C7.2453 36.3561 1 33.675 1 28.0863V19.9423L9 17L17 19.9423V28.0864C17 33.7024 10.763 36.3618 9.0026 37Z" fill="#D3DBEF"/>
            <path d="M8.99943 29C8.86811 29.0001 8.73807 28.9742 8.61675 28.9239C8.49543 28.8736 8.38522 28.7999 8.29243 28.707L6.29243 26.707C6.11027 26.5184 6.00948 26.2658 6.01176 26.0036C6.01403 25.7414 6.1192 25.4906 6.30461 25.3052C6.49002 25.1198 6.74083 25.0146 7.00303 25.0123C7.26523 25.0101 7.51783 25.1108 7.70643 25.293L8.89103 26.4776L11.1994 23.4C11.3586 23.1878 11.5955 23.0476 11.858 23.0101C12.1206 22.9725 12.3873 23.0409 12.5994 23.2C12.8116 23.3591 12.9519 23.596 12.9894 23.8586C13.0269 24.1211 12.9586 24.3878 12.7994 24.6L9.79943 28.6C9.71358 28.7147 9.60403 28.8096 9.47824 28.8782C9.35244 28.9468 9.21336 28.9875 9.07043 28.9975C9.04683 28.999 9.02283 29 8.99943 29Z" fill="#8491C1"/>
            <path d="M43 0H7C6.20462 0.000873479 5.44206 0.317225 4.87964 0.879644C4.31722 1.44206 4.00087 2.20462 4 3V17.7736L0.6548 19.0036C0.462694 19.0743 0.296898 19.2022 0.179801 19.3701C0.062703 19.5379 -5.54009e-05 19.7377 3.66964e-08 19.9424V28.086C3.66964e-08 34.286 6.6274 37.1954 8.6587 37.9395C8.76891 37.9794 8.8852 37.9999 9.0024 38C9.11863 38 9.23397 37.9797 9.3432 37.94C11.1524 37.2831 16.5966 34.9124 17.7656 30H43C43.7954 29.9991 44.5579 29.6828 45.1204 29.1204C45.6828 28.5579 45.9991 27.7954 46 27V3C45.9991 2.20462 45.6828 1.44206 45.1204 0.879644C44.5579 0.317225 43.7954 0.000873479 43 0ZM6 7H44V12H6V7ZM9.0039 35.9307C6.9814 35.1348 2 32.7012 2 28.0859V20.64L9 18.0658L16 20.64V28.0863C16 32.7246 11.0249 35.1416 9.0039 35.9307ZM44 27C43.9997 27.2651 43.8943 27.5193 43.7068 27.7068C43.5193 27.8943 43.2651 27.9997 43 28H18V19.9424C18 19.7378 17.9372 19.5381 17.8201 19.3702C17.703 19.2024 17.5373 19.0745 17.3452 19.0039L9.3452 16.0615C9.12249 15.9796 8.8779 15.9796 8.6552 16.0615L6 17.038V14H44V27ZM6 5V3C6.00026 2.73486 6.10571 2.48066 6.29319 2.29319C6.48066 2.10571 6.73486 2.00026 7 2H43C43.2651 2.00026 43.5193 2.10571 43.7068 2.29319C43.8943 2.48066 43.9997 2.73486 44 3V5H6Z" fill="#231F20"/>
            <path d="M32 25C32.908 24.9961 33.7871 24.6804 34.49 24.1057C35.0769 24.5821 35.7867 24.8824 36.5373 24.9719C37.2878 25.0614 38.0484 24.9364 38.7308 24.6113C39.4132 24.2863 39.9896 23.7746 40.3931 23.1354C40.7967 22.4963 41.0108 21.7559 41.0108 21C41.0108 20.2441 40.7967 19.5037 40.3931 18.8646C39.9896 18.2254 39.4132 17.7137 38.7308 17.3887C38.0484 17.0637 37.2878 16.9386 36.5373 17.0281C35.7867 17.1176 35.0769 17.4179 34.49 17.8943C33.7871 17.3196 32.908 17.0039 32 17C30.9391 17 29.9217 17.4214 29.1716 18.1716C28.4214 18.9217 28 19.9391 28 21C28 22.0609 28.4214 23.0783 29.1716 23.8284C29.9217 24.5786 30.9391 25 32 25ZM39 21C38.9994 21.5302 38.7885 22.0386 38.4135 22.4135C38.0386 22.7885 37.5302 22.9994 37 23C36.5214 23.0018 36.0586 22.8291 35.6981 22.5142C35.8974 22.0343 36 21.5197 36 21.0001C36 20.4804 35.8974 19.9658 35.6981 19.4859C36.0586 19.171 36.5214 18.9983 37 19C37.5302 19.0006 38.0386 19.2115 38.4135 19.5865C38.7885 19.9614 38.9994 20.4698 39 21ZM32 19C32.3956 19 32.7822 19.1173 33.1111 19.3371C33.44 19.5568 33.6964 19.8692 33.8478 20.2346C33.9991 20.6001 34.0387 21.0022 33.9616 21.3902C33.8844 21.7781 33.6939 22.1345 33.4142 22.4142C33.1345 22.6939 32.7781 22.8844 32.3902 22.9616C32.0022 23.0387 31.6001 22.9991 31.2346 22.8478C30.8692 22.6964 30.5568 22.44 30.3371 22.1111C30.1173 21.7822 30 21.3956 30 21C30.0006 20.4698 30.2115 19.9614 30.5865 19.5865C30.9614 19.2115 31.4698 19.0006 32 19Z" fill="#231F20"/>
            <path d="M11.1994 23.4L8.89103 26.4775L7.70643 25.293C7.51783 25.1108 7.26523 25.0101 7.00303 25.0123C6.74083 25.0146 6.49002 25.1198 6.30461 25.3052C6.1192 25.4906 6.01403 25.7414 6.01176 26.0036C6.00948 26.2658 6.11027 26.5184 6.29243 26.707L8.29243 28.707C8.38522 28.7999 8.49543 28.8736 8.61675 28.9239C8.73807 28.9742 8.86811 29.0001 8.99943 29C9.02283 29 9.04683 28.999 9.07023 28.9971C9.21316 28.9871 9.35227 28.9465 9.47809 28.878C9.60392 28.8095 9.71352 28.7147 9.79943 28.6L12.7994 24.6C12.9586 24.3878 13.0269 24.1211 12.9894 23.8586C12.9519 23.596 12.8116 23.3591 12.5994 23.2C12.3873 23.0409 12.1206 22.9725 11.858 23.0101C11.5955 23.0476 11.3586 23.1878 11.1994 23.4Z" fill="#231F20"/>
            </svg>
        ',
        'credit-card' => '<svg width="133" height="33" viewBox="0 0 133 33" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M95.2874 11.9634C95.2452 15.2933 98.255 17.1515 100.522 18.2563C102.852 19.3898 103.634 20.1168 103.625 21.1305C103.608 22.6819 101.767 23.3666 100.044 23.3932C97.0391 23.4398 95.2917 22.5818 93.9026 21.933L92.82 26.9987C94.2137 27.6409 96.7945 28.201 99.4706 28.2256C105.753 28.2256 109.862 25.1247 109.885 20.3169C109.909 14.2151 101.445 13.8773 101.503 11.15C101.522 10.323 102.312 9.44053 104.041 9.21614C104.897 9.10279 107.259 9.01604 109.938 10.2496L110.989 5.34838C109.549 4.82385 107.697 4.32159 105.392 4.32159C99.4796 4.32159 95.3209 7.46472 95.2874 11.9634ZM121.092 4.74376C119.945 4.74376 118.978 5.41286 118.547 6.43966L109.573 27.8656H115.851L117.1 24.4133H124.771L125.495 27.8656H131.028L126.2 4.74376H121.092ZM121.97 10.9898L123.782 19.6723H118.82L121.97 10.9898ZM87.6765 4.74404L82.7284 27.8653H88.7102L93.656 4.74347L87.6765 4.74404ZM78.8274 4.74404L72.6013 20.4814L70.0827 7.10009C69.7872 5.60631 68.6202 4.74376 67.3242 4.74376H57.1465L57.0039 5.41518C59.0934 5.86857 61.4673 6.59985 62.9056 7.38231C63.7858 7.86029 64.0368 8.27812 64.3259 9.41392L69.0961 27.8656H75.4174L85.1088 4.74376L78.8274 4.74404Z" fill="url(#paint0_linear_3383_3096)"/>
            <path d="M7.66968 32.4803V30.3198C7.66968 29.4915 7.16545 28.9515 6.30116 28.9515C5.8691 28.9515 5.40095 29.0955 5.07682 29.5636C4.82487 29.1675 4.46481 28.9515 3.92466 28.9515C3.56444 28.9515 3.20455 29.0594 2.91635 29.4555V29.0235H2.16016V32.4803H2.91635V30.5718C2.91635 29.9598 3.24048 29.6716 3.74471 29.6716C4.24862 29.6716 4.5009 29.9957 4.5009 30.5718V32.4803H5.25709V30.5718C5.25709 29.9598 5.61698 29.6716 6.08513 29.6716C6.58936 29.6716 6.84132 29.9957 6.84132 30.5718V32.4803H7.66968ZM18.8684 29.0235H17.6442V27.9792H16.888V29.0235H16.2038V29.7075H16.8878V31.292C16.8878 32.0843 17.212 32.5523 18.0762 32.5523C18.4004 32.5523 18.7603 32.4444 19.0125 32.3003L18.7963 31.6521C18.5803 31.7961 18.3284 31.8322 18.1482 31.8322C17.7882 31.8322 17.6442 31.6162 17.6442 31.256V29.7075H18.8684V29.0235ZM25.2781 28.9513C24.846 28.9513 24.558 29.1675 24.3779 29.4555V29.0235H23.6217V32.4803H24.3779V30.5359C24.3779 29.9598 24.6298 29.6356 25.098 29.6356C25.242 29.6356 25.4221 29.6717 25.5661 29.7077L25.7822 28.9875C25.6381 28.9515 25.4221 28.9515 25.2781 28.9515M15.5916 29.3117C15.2314 29.0596 14.7274 28.9516 14.1872 28.9516C13.3231 28.9516 12.747 29.3837 12.747 30.0679C12.747 30.6441 13.179 30.9681 13.9352 31.0762L14.2953 31.1123C14.6914 31.1841 14.9075 31.2922 14.9075 31.4723C14.9075 31.7243 14.6194 31.9044 14.1152 31.9044C13.6109 31.9044 13.215 31.7243 12.9629 31.5443L12.6028 32.1204C12.9989 32.4084 13.5391 32.5525 14.0791 32.5525C15.0874 32.5525 15.6636 32.0845 15.6636 31.4362C15.6636 30.8241 15.1955 30.4999 14.4752 30.392L14.1152 30.3559C13.7911 30.3198 13.5391 30.248 13.5391 30.0319C13.5391 29.7798 13.7911 29.6358 14.1872 29.6358C14.6194 29.6358 15.0515 29.8157 15.2675 29.9238L15.5916 29.3117ZM35.6848 28.9516C35.2526 28.9516 34.9645 29.1677 34.7844 29.4557V29.0236H34.0282V32.4805H34.7844V30.536C34.7844 29.9599 35.0366 29.6358 35.5045 29.6358C35.6487 29.6358 35.8288 29.6719 35.9729 29.7078L36.1889 28.9877C36.0449 28.9516 35.8288 28.9516 35.6848 28.9516ZM26.0343 30.752C26.0343 31.7963 26.7544 32.5525 27.8708 32.5525C28.3749 32.5525 28.7349 32.4445 29.095 32.1565L28.7349 31.5443C28.4469 31.7604 28.1588 31.8683 27.8347 31.8683C27.2225 31.8683 26.7905 31.4362 26.7905 30.752C26.7905 30.104 27.2225 29.6717 27.8347 29.6358C28.1588 29.6358 28.4469 29.7437 28.7349 29.9599L29.095 29.3478C28.7349 29.0596 28.3749 28.9516 27.8708 28.9516C26.7544 28.9516 26.0343 29.7078 26.0343 30.752ZM33.0201 30.752V29.0236H32.2639V29.4557C32.0118 29.1317 31.6517 28.9516 31.1836 28.9516C30.2114 28.9516 29.4552 29.7078 29.4552 30.752C29.4552 31.7963 30.2114 32.5525 31.1836 32.5525C31.6877 32.5525 32.0479 32.3725 32.2639 32.0484V32.4805H33.0201V30.752ZM30.2473 30.752C30.2473 30.1399 30.6434 29.6358 31.2915 29.6358C31.9037 29.6358 32.3359 30.104 32.3359 30.752C32.3359 31.3642 31.9037 31.8683 31.2915 31.8683C30.6434 31.8322 30.2473 31.3642 30.2473 30.752ZM21.2091 28.9516C20.2008 28.9516 19.4805 29.6717 19.4805 30.752C19.4805 31.8324 20.2006 32.5525 21.245 32.5525C21.7491 32.5525 22.2533 32.4084 22.6495 32.0845L22.2893 31.5443C22.0012 31.7604 21.6412 31.9044 21.2811 31.9044C20.813 31.9044 20.3448 31.6883 20.2367 31.076H22.7935V30.7881C22.8296 29.6717 22.1815 28.9516 21.2091 28.9516ZM21.2089 29.5997C21.6769 29.5997 22.0012 29.8879 22.0731 30.4281H20.2726C20.3446 29.9599 20.6688 29.5997 21.2089 29.5997ZM39.9697 30.752V27.6553H39.2135V29.4557C38.9614 29.1317 38.6013 28.9516 38.1332 28.9516C37.1609 28.9516 36.4048 29.7078 36.4048 30.752C36.4048 31.7963 37.1609 32.5525 38.1332 32.5525C38.6374 32.5525 38.9975 32.3725 39.2135 32.0484V32.4805H39.9697V30.752ZM37.197 30.752C37.197 30.1399 37.593 29.6358 38.2413 29.6358C38.8534 29.6358 39.2855 30.104 39.2855 30.752C39.2855 31.3642 38.8534 31.8683 38.2413 31.8683C37.593 31.8322 37.197 31.3642 37.197 30.752ZM11.9185 30.752V29.0236H11.1623V29.4557C10.9101 29.1317 10.5501 28.9516 10.0819 28.9516C9.10973 28.9516 8.35354 29.7078 8.35354 30.752C8.35354 31.7963 9.10973 32.5525 10.0819 32.5525C10.5862 32.5525 10.9462 32.3725 11.1623 32.0484V32.4805H11.9185V30.752ZM9.10973 30.752C9.10973 30.1399 9.50586 29.6358 10.154 29.6358C10.7661 29.6358 11.1984 30.104 11.1984 30.752C11.1984 31.3642 10.7661 31.8683 10.154 31.8683C9.50586 31.8322 9.10973 31.3642 9.10973 30.752Z" fill="black"/>
            <path d="M15.3359 2.77246H26.6788V23.1537H15.3359V2.77246Z" fill="#FF5F00"/>
            <path d="M16.0593 12.9633C16.0593 8.82233 18.0038 5.14931 20.9925 2.77264C18.7961 1.04423 16.0234 0 12.9987 0C5.83256 0 0.0351562 5.7974 0.0351562 12.9633C0.0351562 20.1293 5.83256 25.9267 12.9985 25.9267C16.0233 25.9267 18.7959 24.8824 20.9925 23.1539C18.0038 20.8133 16.0593 17.1043 16.0593 12.9633Z" fill="#EB001B"/>
            <path d="M41.9846 12.9633C41.9846 20.1291 36.1872 25.9267 29.0213 25.9267C25.9965 25.9267 23.2239 24.8824 21.0273 23.1539C24.0521 20.7774 25.9606 17.1043 25.9606 12.9633C25.9606 8.82233 24.016 5.14931 21.0273 2.77264C23.2237 1.04423 25.9965 0 29.0213 0C36.1872 0 41.9846 5.83349 41.9846 12.9633Z" fill="#F79E1B"/>
            <defs>
            <linearGradient id="paint0_linear_3383_3096" x1="3460.19" y1="76.177" x2="3529.38" y2="-2378.8" gradientUnits="userSpaceOnUse">
            <stop stop-color="#222357"/>
            <stop offset="1" stop-color="#254AA5"/>
            </linearGradient>
            </defs>
            </svg>',
        'revolut' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20.9148 6.957C20.9148 3.12 17.7918 0 13.9518 0H2.42578V3.86H13.4038C15.1418 3.86 16.5808 5.226 16.6128 6.904C16.6218 7.31655 16.5479 7.72672 16.3953 8.11014C16.2428 8.49356 16.0148 8.84242 15.7248 9.136C15.4368 9.43138 15.0925 9.66591 14.7122 9.82566C14.3318 9.98542 13.9233 10.0671 13.5108 10.066H9.23378C9.16093 10.0663 9.09113 10.0953 9.03962 10.1468C8.9881 10.1984 8.95904 10.2681 8.95878 10.341V13.772C8.95878 13.832 8.97611 13.886 9.01078 13.934L16.2668 24H21.5778L14.3048 13.906C17.9678 13.722 20.9148 10.646 20.9148 6.957ZM6.89578 5.923H2.42578V24H6.89578V5.923Z" fill="black"/>
            </svg>',
        'google-pay' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_3079_2221)">
            <path d="M8.35909 0.788944C5.96112 1.62082 3.89311 3.19976 2.45882 5.29382C1.02454 7.38789 0.299573 9.88671 0.390418 12.4233C0.481264 14.9598 1.38313 17.4004 2.96355 19.3864C4.54396 21.3725 6.71962 22.7995 9.17096 23.4577C11.1583 23.9705 13.2405 23.993 15.2385 23.5233C17.0484 23.1168 18.7218 22.2471 20.0947 20.9996C21.5236 19.6615 22.5608 17.9592 23.0947 16.0758C23.6751 14.0277 23.7783 11.8738 23.3966 9.77957H12.2366V14.4089H18.6997C18.5705 15.1473 18.2937 15.852 17.8859 16.4809C17.478 17.1098 16.9474 17.6499 16.326 18.0689C15.5367 18.591 14.6471 18.9423 13.7141 19.1002C12.7784 19.2742 11.8186 19.2742 10.8828 19.1002C9.93444 18.9041 9.03727 18.5127 8.24846 17.9508C6.98124 17.0538 6.02973 15.7794 5.52971 14.3096C5.02124 12.8122 5.02124 11.1888 5.52971 9.69144C5.88564 8.64185 6.47403 7.6862 7.25096 6.89582C8.14007 5.97472 9.26571 5.31631 10.5044 4.99284C11.7431 4.66936 13.0469 4.69331 14.2728 5.06207C15.2305 5.35605 16.1063 5.8697 16.8303 6.56207C17.5591 5.83707 18.2866 5.11019 19.0128 4.38144C19.3878 3.98957 19.7966 3.61644 20.166 3.21519C19.0608 2.18671 17.7635 1.38643 16.3485 0.860194C13.7717 -0.0754498 10.9522 -0.100594 8.35909 0.788944Z" fill="white"/>
            <path d="M8.35875 0.789855C10.9516 -0.100288 13.7711 -0.0758051 16.3481 0.85923C17.7634 1.38904 19.0601 2.19318 20.1638 3.22548C19.7888 3.62673 19.3931 4.00173 19.0106 4.39173C18.2831 5.11798 17.5562 5.84173 16.83 6.56298C16.106 5.87061 15.2302 5.35696 14.2725 5.06298C13.047 4.69293 11.7432 4.66759 10.5042 4.98975C9.26516 5.3119 8.13883 5.9691 7.24875 6.88923C6.47181 7.67961 5.88342 8.63526 5.5275 9.68486L1.64062 6.67548C3.03189 3.91653 5.44078 1.80615 8.35875 0.789855Z" fill="#E33629"/>
            <path d="M0.611401 9.65605C0.820316 8.62067 1.16716 7.61798 1.64265 6.6748L5.52953 9.69168C5.02105 11.1891 5.02105 12.8124 5.52953 14.3098C4.23453 15.3098 2.9389 16.3148 1.64265 17.3248C0.452308 14.9554 0.0892746 12.2557 0.611401 9.65605Z" fill="#F8BD00"/>
            <path d="M12.2391 9.77832H23.3991C23.7809 11.8726 23.6776 14.0264 23.0972 16.0746C22.5633 17.958 21.5261 19.6602 20.0972 20.9983C18.8429 20.0196 17.5829 19.0483 16.3285 18.0696C16.9504 17.6501 17.4812 17.1094 17.8891 16.4798C18.297 15.8503 18.5735 15.1448 18.7022 14.4058H12.2391C12.2372 12.8646 12.2391 11.3214 12.2391 9.77832Z" fill="#587DBD"/>
            <path d="M1.64062 17.3246C2.93688 16.3246 4.2325 15.3196 5.5275 14.3096C6.02851 15.7799 6.98138 17.0544 8.25 17.9508C9.04126 18.5101 9.94037 18.8983 10.89 19.0908C11.8257 19.2648 12.7855 19.2648 13.7213 19.0908C14.6542 18.9329 15.5439 18.5816 16.3331 18.0596C17.5875 19.0383 18.8475 20.0096 20.1019 20.9883C18.7292 22.2366 17.0558 23.1068 15.2456 23.5139C13.2476 23.9836 11.1655 23.9611 9.17813 23.4483C7.60632 23.0286 6.13814 22.2888 4.86563 21.2752C3.51874 20.2059 2.41867 18.8583 1.64062 17.3246Z" fill="#319F43"/>
            </g>
            <defs>
            <clipPath id="clip0_3079_2221">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>
            ',
        'apple-pay' => '<svg width="24" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.9966 26.8766C18.4459 28.3542 16.7527 28.1209 15.1229 27.421C13.3981 26.7055 11.8157 26.6744 9.99598 27.421C7.71736 28.3853 6.51476 28.1053 5.15392 26.8766C-2.56807 19.0532 -1.42876 7.1391 7.3376 6.7036C9.4738 6.81247 10.9612 7.85456 12.2113 7.94789C14.0785 7.5746 15.8666 6.5014 17.8604 6.64138C20.2498 6.82803 22.0537 7.76124 23.2405 9.44103C18.3035 12.3496 19.4744 18.7421 24 20.5307C23.098 22.8638 21.9271 25.1813 19.9808 26.8922L19.9966 26.8766ZM12.0531 6.61028C11.8157 3.14183 14.6798 0.279965 17.9712 0C18.43 4.01283 14.2684 6.99912 12.0531 6.61028Z" fill="black"/>
            </svg>
            '
    );

    if (isset($svg_icons[$icon_name])) {
        // Define allowed HTML tags and attributes for SVG
        $kses_defaults = wp_kses_allowed_html('post');

        $svg_args = array(
            'svg' => array(
                'width' => true,
                'height' => true,
                'xmlns' => true,
                'viewbox' => true,
                'fill' => true,
                'class' => true,
            ),
            'path' => array(
                'd' => true,
                'fill' => true,
                'stroke' => true,
                'stroke-width' => true,
                'stroke-linecap' => true,
                'stroke-linejoin' => true,
            ),
        );

        $allowed_tags = array_merge($kses_defaults, $svg_args);

        return sprintf(
            '<div class="lapinopay-payment-icon" role="img" aria-label="%s">%s</div>',
            esc_attr($alt_text),
            wp_kses($svg_icons[$icon_name], $allowed_tags)
        );
    }

    // Fallback if icon not found
    return sprintf(
        '<span class="lapinopay-payment-icon" aria-label="%s"></span>',
        esc_attr($alt_text)
    );
}
?>
<style>
    #add_payment_method #payment div.payment_box::before,
    .woocommerce-cart #payment div.payment_box::before,
    .woocommerce-checkout #payment div.payment_box::before {
        display: none !important;
    }

    .payment_box.payment_method_lapinopay-instant-payment-gateway-guardarian {
        background-color: transparent !important;
        padding: 0 !important;
        border: none !important;
        margin: 0 !important;
    }

    .form-row.place-order {
        display: none !important;
        padding: 0 !important;
    }

    .woocommerce-terms-and-conditions-wrapper {
        padding: 0 !important;
        background: transparent !important;
        display: none !important;
    }

    .lapinopay-additional-fields {
        display: none !important;
    }

    #payment .payment_methods>li>label,
    #payment .payment_methods>li {
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .lapinopay-additional-fields select {
        display: none !important;
    }

    #payment .payment_methods>li:first-child {
        border-top: none !important;
    }

    .lapinopay-payment-container {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        max-width: 100%;
        margin: 0;
    }

    /* Add styles for payment icons */
    .lapinopay-payment-icon {
        display: flex;
        align-items: center;
        height: 100%;
        color: #1a1a1a;
    }

    .lapinopay-payment-icon svg {
        width: 100%;
        height: 100%;
    }

    /* Specific icon colors */
    .lapinopay-payment-method[data-method="google-pay"] .lapinopay-payment-icon {
        color: #4285f4;
    }

    .lapinopay-payment-method[data-method="apple-pay"] .lapinopay-payment-icon {
        color: #000000;
    }

    .lapinopay-payment-method[data-method="revolut"] .lapinopay-payment-icon {
        color: #0666eb;
    }

    .lapinopay-security-badge {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        /* background: #f8f9fa; */
        border-radius: 20px;
        color: #1a1a1a;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 24px;
        width: 98%;
    }

    .lapinopay-security-badge img {
        width: 46px;
        /* height: 16px; */
    }

    .lapinopay-payment-methods {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .lapinopay-payment-method {
        position: relative;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .lapinopay-payment-method:hover {
        background: #f8f9fa;
        border-color: #000;
    }

    .lapinopay-payment-method.selected {
        border-color: #000;
        background: #f8f9fa;
    }

    .lapinopay-payment-method input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .lapinopay-payment-method label {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 0;
        cursor: pointer;
        flex-direction: row-reverse;
    }

    .lapinopay-payment-method-icon {
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lapinopay-payment-method-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .lapinopay-payment-method-info {
        flex-grow: 1;
    }

    .lapinopay-payment-method-name {
        font-weight: 500;
        color: #1a1a1a;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .lapinopay-payment-method-description {
        font-size: 14px;
        color: #6c757d;
    }

    .lapinopay-radio-check {
        width: 20px;
        height: 20px;
        border: 2px solid #dee2e6;
        border-radius: 50%;
        position: relative;
        transition: all 0.2s ease;
    }

    .lapinopay-payment-method.selected .lapinopay-radio-check {
        border-color: #000;
    }

    .lapinopay-payment-method.selected .lapinopay-radio-check:after {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background: #000;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .lapinopay-footer {
        margin-top: 24px;
        font-size: 14px;
        color: #6c757d;
        line-height: 1.5;
    }

    .lapinopay-footer a {
        color: #000;
        text-decoration: underline;
    }

    #place_order {
        display: none !important;
    }

    .lapinopay-place-order {
        width: 100%;
        padding: 16px 24px;
        background: #000000;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 24px;
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .lapinopay-place-order:hover {
        background: #333333;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .lapinopay-place-order:active {
        transform: translateY(0);
    }

    .lapinopay-place-order:disabled {
        background: #cccccc;
        cursor: not-allowed;
    }

    @media (max-width: 400px) {
        .lapinopay-payment-container {
            padding: 8px;
        }
        .lapinopay-payment-method-icon {
            height: 20px;
        }
        .lapinopay-payment-icon svg,
        .lapinopay-payment-method-icon img {
            height: 20px !important;
        }
        .lapinopay-payment-method-description {
            display: none !important;
        }
        .lapinopay-radio-check {
            width: 20px !important;
            height: 20px !important;
            min-width: 20px !important;
            min-height: 20px !important;
            max-width: 20px !important;
            max-height: 20px !important;
        }
        .lapinopay-payment-method label {
            gap: 8px;
        }
        .lapinopay-payment-method {
            padding: 10px;
        }
    }
</style>

<!-- Hidden select for form submission -->
<select name="lapinopay_payment_category" id="lapinopay_payment_category" class="select" style="display: none;"
    required>
    <option value="">Select a payment method</option>
    <option value="VISA_MC">Credit Card</option>
    <option value="REVOLUT_PAY">Revolut Pay</option>
    <option value="GOOGLE_PAY">Google Pay</option>
    <option value="APPLE_PAY">Apple Pay</option>
</select>

<div class="lapinopay-payment-container">
    <div class="lapinopay-security-badge">
        <?php echo wp_kses_post(lapinopay_get_payment_icon('shield-check', 'Security')); ?>
        <!-- <span>Secure Payment</span> -->
    </div>

    <div class="lapinopay-payment-methods">
        <div class="lapinopay-payment-method selected" data-method="credit-card">
            <input type="radio" name="lapinopay_payment_method" id="credit-card" value="credit-card" checked>
            <label for="credit-card">
                <div class="lapinopay-payment-method-icon">
                    <?php echo wp_kses_post(lapinopay_get_payment_icon('credit-card', 'Credit Card')); ?>
                </div>
                <div class="lapinopay-payment-method-info">
                    <div class="lapinopay-payment-method-name">Credit Card</div>
                    <div class="lapinopay-payment-method-description">Pay securely with your credit card</div>
                </div>
                <span class="lapinopay-radio-check"></span>
            </label>
        </div>

        <div class="lapinopay-payment-method" data-method="revolut">
            <input type="radio" name="lapinopay_payment_method" id="revolut" value="revolut">
            <label for="revolut">
                <div class="lapinopay-payment-method-icon">
                    <?php echo wp_kses_post(lapinopay_get_payment_icon('revolut', 'Revolut')); ?>
                </div>
                <div class="lapinopay-payment-method-info">
                    <div class="lapinopay-payment-method-name">Revolut Pay</div>
                    <div class="lapinopay-payment-method-description">Fast and secure payment with Revolut</div>
                </div>
                <span class="lapinopay-radio-check"></span>
            </label>
        </div>

        <div class="lapinopay-payment-method" data-method="apple-pay">
            <input type="radio" name="lapinopay_payment_method" id="apple-pay" value="apple-pay">
            <label for="apple-pay">
                <div class="lapinopay-payment-method-icon">
                    <?php echo wp_kses_post(lapinopay_get_payment_icon('apple-pay', 'Apple Pay')); ?>
                </div>
                <div class="lapinopay-payment-method-info">
                    <div class="lapinopay-payment-method-name">Apple Pay</div>
                    <div class="lapinopay-payment-method-description">Quick checkout with Apple Pay</div>
                </div>
                <span class="lapinopay-radio-check"></span>
            </label>
        </div>

        <div class="lapinopay-payment-method" data-method="google-pay">
            <input type="radio" name="lapinopay_payment_method" id="google-pay" value="google-pay">
            <label for="google-pay">
                <div class="lapinopay-payment-method-icon">
                    <?php echo wp_kses_post(lapinopay_get_payment_icon('google-pay', 'Google Pay')); ?>
                </div>
                <div class="lapinopay-payment-method-info">
                    <div class="lapinopay-payment-method-name">Google Pay</div>
                    <div class="lapinopay-payment-method-description">Easy payment with Google Pay</div>
                </div>
                <span class="lapinopay-radio-check"></span>
            </label>
        </div>
    </div>

    <div class="lapinopay-footer">
        Your personal data will be used to process your order, support your experience throughout this website, and for
        other purposes described in our <a target="_blank" href="https://www.lapinopay.com/privacy">Privacy
            policy</a>.
    </div>

    <button type="submit" class="lapinopay-place-order" id="lapinopay-place-order">
        Place order
    </button>
</div>

<script>
    jQuery(function ($) {
        // Get the hidden select element - Fix the selector to make sure we get the right element
        const payment_field_category = $('#lapinopay_payment_category');

        const paymentCategories = {
            'credit-card': 'VISA_MC',
            'revolut': 'REVOLUT_PAY',
            'google-pay': 'GOOGLE_PAY',
            'apple-pay': 'APPLE_PAY'
        };

        function updatePaymentCategory(selectedValue) {
            // Log for debugging
            console.log('Updating payment category to:', paymentCategories[selectedValue]);

            // Make sure we have the select element
            if (payment_field_category.length) {
                // Update the value and trigger change event
                payment_field_category.val(paymentCategories[selectedValue]).trigger('change');
            } else {
                console.error('Payment category select element not found');
            }
        }

        // Handle click on payment method container
        $(document).on('click', '.lapinopay-payment-method', function (e) {
            e.preventDefault();

            const radio = $(this).find('input[type="radio"]');
            if (radio.length) {
                // Update UI
                $('.lapinopay-payment-method').removeClass('selected');
                $(this).addClass('selected');

                // Update radio buttons
                $('.lapinopay-payment-method input[type="radio"]').prop('checked', false);
                radio.prop('checked', true);

                // Update hidden select
                updatePaymentCategory(radio.val());
            }
        });

        // Set initial value based on default selected radio
        const defaultSelected = $('.lapinopay-payment-method input[type="radio"]:checked');
        if (defaultSelected.length) {
            updatePaymentCategory(defaultSelected.val());
        }

        // Handle WooCommerce checkout updates
        $(document.body).on('updated_checkout', function () {
            console.log('Checkout updated, re-checking payment methods');
            const selectedRadio = $('.lapinopay-payment-method input[type="radio"]:checked');
            if (selectedRadio.length) {
                updatePaymentCategory(selectedRadio.val());
            }
        });

        // Add click handler for the place order button
        $('#lapinopay-place-order').on('click', function (e) {
            e.preventDefault();
            // Trigger the original place order button
            $('#place_order').trigger('click');
        });
    });
</script>